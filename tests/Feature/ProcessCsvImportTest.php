<?php 

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;


it('processes CSV data and creates news items', function () {
    Storage::fake();

    $file = UploadedFile::fake()->createWithContent('valid.csv', "title,content,category\nHello,World,tech-news");
    $response = $this->postJson('/api/import', [
        'file' => $file,
    ]);

    $importId = $response->json('id');
    $this->artisan("queue:work --once");

    $this->assertDatabaseCount('news_items', 1);
    $this->assertDatabaseHas('news_items', [
        'title' => 'Hello',
        'content' => 'World',
    ]);
});