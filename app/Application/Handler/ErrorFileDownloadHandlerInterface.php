<?php 

namespace App\Application\Handler;

interface ErrorFileDownloadHandlerInterface
{
    /**
     * Handle the error file download request.
     *
     * @param int $importRequestId
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleErrorFileDownload(int $importRequestId): mixed;
}