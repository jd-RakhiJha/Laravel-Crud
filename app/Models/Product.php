<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\WithData;

class product extends Model
{
    use HasFactory, WithData;

    protected $fillable = [
        'name',
        'price',
        'description'
    ];

    protected $casts = [
        'name'        => 'string',
        'price'       => 'decimal:2',
        'description' => 'string',
    ];
}
