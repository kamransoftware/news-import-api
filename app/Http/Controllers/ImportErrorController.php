<?php

namespace App\Http\Controllers;

use App\Application\Handler\ErrorFileDownloadHandlerInterface;

class ImportErrorController
{
    public function downloadErrors($importRequestId, ErrorFileDownloadHandlerInterface $errorFileDownloadHandler): mixed
    {
        return $errorFileDownloadHandler->handleErrorFileDownload($importRequestId);
    }
}
