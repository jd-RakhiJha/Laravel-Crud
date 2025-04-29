<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'unit_price',
        'minimum_stock',
        'location',
        'status',
        'last_restock_date',
        'last_restock_quantity',
        'inventoryable_type',
        'inventoryable_id',
        'category_id'
    ];

    protected $casts = [
        'last_restock_date' => 'datetime',
        'unit_price' => 'decimal:2',
        'minimum_stock' => 'integer',
        'quantity' => 'integer',
        'last_restock_quantity' => 'integer'
    ];

    public function inventoryable(): MorphTo
    {
        return $this->morphTo();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
