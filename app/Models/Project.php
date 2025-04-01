<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'name'        => 'string',
        'description' => 'string',
        'start_date'  => 'date',
        'end_date'    => 'date',
        'status'      => 'string',
    ];
    protected $attributes = [
        'status' => 'pending',
    ];
}
