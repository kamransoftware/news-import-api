<?php

use App\Http\Controllers\ImportController;
use App\Http\Controllers\ImportErrorController;
use Illuminate\Support\Facades\Route;

Route::post('/import', [ImportController::class, 'upload']);
Route::get('/imports', [ImportController::class, 'index']);
Route::get('/imports/{id}/errors', [ImportErrorController::class, 'downloadErrors']);
