<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('skips Invalid rows and saves in error log', function () {
    Storage::fake('local');

    $file = UploadedFile::fake()->createWithContent('invalid.csv', "title,content,category\n,sdsd,");
    $response = $this->postJson('/api/import', ['file' => $file]);

    $importId = $response->json('id');
    $this->artisan("queue:work --once");

    $errors = Storage::disk('local')->files('errors');
    expect($errors)->not->toBeEmpty();
});