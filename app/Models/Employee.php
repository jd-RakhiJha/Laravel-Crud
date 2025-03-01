<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\WithData;

class Employee extends Model
{
    use HasFactory, WithData;

    protected $fillable = [
        'name',
        'email',
        'position',
        'salary'
    ];

    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'position' => 'string',
        'salary' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
