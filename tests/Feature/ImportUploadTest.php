<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('creates an import request on CSV file upload', function () {
    Storage::fake();
    $file = UploadedFile::fake()->createWithContent('valid.csv', "title,content,category\nExample Title,Example Content,news");

    $response = $this->postJson('/api/import', [
        'file' => $file,
    ]);

    $response->assertOk();
    $response->assertJsonStructure(['message', 'import_id']);
});
