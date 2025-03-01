<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id');
    }
}
