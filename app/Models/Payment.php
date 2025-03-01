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
        'user_id',
        'amount',
        'payment_method',
        'status',
    ];

    protected $casts = [
        'user_id'        => 'integer',
        'amount'         => 'decimal:2',
        'payment_method' => 'string',
        'status'         => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
