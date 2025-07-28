<?php

namespace App\Http\Controllers;

use App\Application\Handler\CsvFileUploadHandlerInterface as HandlerCsvFileUploadHandlerInterface;
use App\Application\Handler\ImportListRequestHandlerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ImportController
{
    public function upload(Request $request, HandlerCsvFileUploadHandlerInterface $csvFileUploadHandler): JsonResponse
    {
        return $csvFileUploadHandler->handleUpload($request);
    }

    public function index(Request $request, ImportListRequestHandlerInterface $importListRequestHandler): JsonResponse
    {
        return $importListRequestHandler->handleListRequest($request);
    }
}
