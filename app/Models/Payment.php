<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\LaravelData\WithData;

class Payment extends Model
{
    use HasFactory, WithData;

    protected $fillable = [
        'amount',
        'payment_method',
        'status',
    ];

    protected $casts = [
        'amount'         => 'decimal:2',
        'payment_method' => 'string',
        'status'         => 'string',
    ];
}
