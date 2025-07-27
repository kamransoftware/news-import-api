<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImportRequest;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ProcessCsvImport;
use Illuminate\Support\Facades\Bus;

class ImportController
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $filePath = $request->file('file')->store('imports');

        $import = ImportRequest::create([
            'file_path' => $filePath,
            'status' => 'pending',
        ]);

        // Dispatch the job to process the CSV import
        Bus::dispatch(new ProcessCsvImport($import->id, $filePath));

        return response()->json([
            'message' => 'Import started.',
            'import_id' => $import->id,
        ]);
    }

    public function index(Request $request)
    {
        $query = ImportRequest::query();

        if ($request->has('id')) {
            $query->where('id', $request->id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->latest()->get());
    }

    public function downloadErrors($id)
    {
        $import = ImportRequest::findOrFail($id);

        if (!$import->error_file_path || !Storage::exists($import->error_file_path)) {
            return response()->json(['message' => 'No error file available.'], 404);
        }

        return response()->download(Storage::path($import->error_file_path));
    }
}
