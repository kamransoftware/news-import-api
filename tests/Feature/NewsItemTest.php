<?php

use App\Models\ImportRequest;
use App\Models\NewsItem;

it('parses categories from dash-separated values', function () {

    $importRequest = ImportRequest::factory()->create();

    $newsItem = NewsItem::create([
        'import_request_id' => $importRequest->id,
        'title' => 'Sample',
        'content' => 'Some text',
        'url' => 'http://example.com/sample'
    ]);

    $sportsCategory = \App\Models\Category::create(['name' => 'sports']);
    $healthCategory = \App\Models\Category::create(['name' => 'health']);
    $techCategory = \App\Models\Category::create(['name' => 'tech']);

    $newsItem->categories()->sync([$sportsCategory->id, $healthCategory->id, $techCategory->id]);
    
    $this->assertDatabaseHas('categories', ['name' => 'sports']);
    $this->assertDatabaseHas('categories', ['name' => 'health']);
    $this->assertDatabaseHas('categories', ['name' => 'tech']);
    
    $this->assertDatabaseHas('category_news_item', [
        'news_item_id' => $newsItem->id,
        'category_id' => $sportsCategory->id,
    ]);

    $this->assertDatabaseHas('category_news_item', [
        'news_item_id' => $newsItem->id,
        'category_id' => $healthCategory->id,
    ]);

    $this->assertDatabaseHas('category_news_item', [
        'news_item_id' => $newsItem->id,
        'category_id' => $techCategory->id,
    ]);
});