<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }
}
