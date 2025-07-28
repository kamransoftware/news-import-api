<?php

namespace App\Application\Dispatcher;

use App\Jobs\ProcessCsvImport;
use Illuminate\Support\Facades\Bus;

class ImportJobDispatcher implements ImportJobDispatcherInterface
{
    /**
     * Dispatch a job to process the import.
     *
     * @param string $filePath The path to the file to be imported.
     * @param int $importRequestId The ID of the import request.
     * @return void
     */
    public function dispatchImportJob(string $filePath, int $importRequestId): void {
        // Dispatch the job to process the CSV import
        Bus::dispatch(new ProcessCsvImport($importRequestId, $filePath));
    }
}