<?php

namespace App\Application\Handler;

use App\Application\Dispatcher\ImportJobDispatcherInterface;
use App\Application\Validator\FileUploadValidatorInterface;
use App\Models\ImportRequest;
use Illuminate\Http\JsonResponse;

class CsvFileUploadHandler implements CsvFileUploadHandlerInterface
{
    protected $validator;
    protected $jobDispatcher;

    public function __construct(FileUploadValidatorInterface $validator, ImportJobDispatcherInterface $jobDispatcher)
    {
        $this->validator = $validator;
        $this->jobDispatcher = $jobDispatcher;
    }

    public function handleUpload(\Illuminate\Http\Request $request): JsonResponse
    {
        $this->validator->validate($request);

        $filePath = $request->file('file')->store('imports');

        $import = ImportRequest::create([
            'file_path' => $filePath,
            'status' => 'pending',
        ]);

        $this->jobDispatcher->dispatchImportJob($filePath, $import->id);

        return response()->json([
            'message' => 'Import started.',
            'import_id' => $import->id,
        ]);
    }
}