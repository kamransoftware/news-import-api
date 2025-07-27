<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
    protected $fillable = ['import_request_id', 'title', 'content', 'category', 'url'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
