<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\WithData;

class Category extends Model
{
    use HasFactory, WithData;

    protected $table = 'categories';

    protected $fillable = ['name', 'type'];
}
