<?php 

namespace App\Application\Handler;

use App\Models\ImportRequest;
use Illuminate\Support\Facades\Storage;

class ErrorFileDownloadHandler implements ErrorFileDownloadHandlerInterface
{
    /**
     * Handle the error file download request.
     *
     * @param int $importRequestId
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleErrorFileDownload(int $importRequestId): mixed
    {
        $import = ImportRequest::findOrFail($importRequestId);

        if (!$import->error_file_path || !Storage::exists($import->error_file_path)) {
            return response()->json(['message' => 'No error file available.'], 404);
        }

        return response()->download(Storage::path($import->error_file_path));
    }
}