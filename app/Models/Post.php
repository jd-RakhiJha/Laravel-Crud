<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\WithData;

class Post extends Model
{
    use HasFactory, WithData;

    protected $fillable = [
        'title',
        'content',
    ];

    protected $casts = [
        'content' => 'string',
    ];
}
