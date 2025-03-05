<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\LaravelData\WithData;

class User extends Model
{
    use HasFactory, WithData;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email'
    ];

    protected $casts = [
        'email' => 'string',
        'name'  => 'string',
    ];

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
