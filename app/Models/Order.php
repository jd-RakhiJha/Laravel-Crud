<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\LaravelData\WithData;

class Order extends Model
{
    use HasFactory, WithData;

    protected $fillable = [
        'order_number',
        'total_price'
    ];

    protected $casts = [
        'order_number'  => 'string',
        'total_price'   => 'decimal:2',
    ];
}
