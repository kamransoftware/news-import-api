<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportRequest extends Model
{
    use HasFactory;
    protected $fillable = ['file_path', 'status', 'error_file_path'];
}
