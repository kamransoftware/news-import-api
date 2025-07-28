<?php 

namespace App\Application\Handler;

interface CsvFileUploadHandlerInterface
{
    /**
     * Handle the file upload and dispatch the import job.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleUpload(\Illuminate\Http\Request $request): \Illuminate\Http\JsonResponse;
}