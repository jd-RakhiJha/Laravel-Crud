<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\LaravelData\WithData;

class Contact extends Model
{
    use HasFactory, WithData;

    protected $fillable = [
        'email',
        'phone',
        'address',
        'user_id',
    ];

    protected $casts = [
        'email' => 'string',
        'phone' => 'string',
        'address' => 'string',
        'user_id' => 'int',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
