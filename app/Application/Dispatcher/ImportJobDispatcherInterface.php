<?php 

namespace App\Application\Dispatcher;

interface ImportJobDispatcherInterface
{
    /**
     * Dispatch a job to process the import.
     *
     * @param string $filePath The path to the file to be imported.
     * @param int $importRequestId The ID of the import request.
     * @return void
     */
    public function dispatchImportJob(string $filePath, int $importRequestId): void;
}