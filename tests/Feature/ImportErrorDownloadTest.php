<?php
namespace Tests\Feature;

use App\Models\ImportRequest;
use Illuminate\Support\Facades\Storage;

it('returns the error file for download if it exists', function () {
    Storage::fake('local');

    $filePath = 'private/errors/import_errors_1.xlsx';
    Storage::put($filePath, 'Fake Excel Content');

    $import = ImportRequest::factory()->create([
        'error_file_path' => $filePath,
    ]);

    $response = $this->get("/api/imports/{$import->id}/errors");

    $response->assertStatus(200);
    $response->assertHeader('content-disposition', 'attachment; filename=import_errors_' . $import->id . '.xlsx');
});

it('returns 404 if the error file does not exist', function () {
    $import = ImportRequest::factory()->create([
        'error_file_path' => 'private/errors/nonexistent.xlsx',
    ]);

    $response = $this->get("/api/imports/{$import->id}/errors");

    $response->assertStatus(404);
    $response->assertJson([
        'message' => 'No error file available.'
    ]);
});

it('returns 404 if no error file path is set', function () {
    $import = ImportRequest::factory()->create([
        'error_file_path' => null,
    ]);

    $response = $this->get("/api/imports/{$import->id}/errors");

    $response->assertStatus(404);
    $response->assertJson([
        'message' => 'No error file available.'
    ]);
});
