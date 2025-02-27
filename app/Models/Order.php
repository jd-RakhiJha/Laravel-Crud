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
        'user_id',
        'order_number',
        'total_price'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
