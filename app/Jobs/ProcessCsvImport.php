<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\ImportRequest;
use App\Models\NewsItem;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProcessCsvImport implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $importId;
    protected $filePath;

    public function __construct($importId, $filePath)
    {
        $this->importId = $importId;
        $this->filePath = $filePath;
    }

    public function handle()
    {
        $import = ImportRequest::find($this->importId);
        if (!$import) return;

        $import->update(['status' => 'processing']);

        $file = Storage::path($this->filePath);
        $csv = Reader::createFromPath($file, 'r');
        $csv->setHeaderOffset(0); // assumes headers

        $records = $csv->getRecords();
        $errors = [];
        $rowNum = 1;

        foreach ($records as $row) {
            $rowNum++;

            $validator = Validator::make($row, [
                'title' => 'required|string',
                'content' => 'required|string',
                'category' => 'required|string',
                'URL' => 'nullable|url',
            ]);

            if ($validator->fails()) {
                $errors[] = [
                    'row' => $rowNum,
                    'errors' => implode(', ', $validator->errors()->all()),
                ];
                continue;
            }

            $categoryNames = explode('-', $row['category'] ?? '');

            $newsItem = NewsItem::create([
                'import_request_id' => $import->id,
                'title' => $row['title'],
                'content' => $row['content'],
                'url' => $row['URL'] ?? null,
            ]);

            $categoryIds = collect($categoryNames)
                ->filter() // remove empty
                ->map(fn ($name) => Category::firstOrCreate(['name' => trim($name)])->id)
                ->toArray();

            $newsItem->categories()->sync($categoryIds);

            $newsItem->save();
        }

        // Export errors to Excel if needed
        if (count($errors) > 0) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->fromArray(['Row', 'Error'], NULL, 'A1');

            foreach ($errors as $i => $error) {
                $sheet->setCellValue("A" . ($i + 2), $error['row']);
                $sheet->setCellValue("B" . ($i + 2), $error['errors']);
            }

            $errorPath = "errors/import_errors_{$import->id}.xlsx";
            $writer = new Xlsx($spreadsheet);

            $fullPath = Storage::path($errorPath);

            // Ensure directory exists
            File::ensureDirectoryExists(dirname($fullPath));

            // Now save the Excel file
            $writer->save($fullPath);

            $import->update([
                'status' => 'completed',
                'error_file_path' => $errorPath,
            ]);
        } else {
            $import->update(['status' => 'completed']);
        }
    }

    public function middleware(): array
    {
        return [(new WithoutOverlapping($this->importId))->expireAfter(300)];
    }
}
