<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\WithData;

class User extends Model
{
    use HasFactory, WithData;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email'
    ];

    public function product()
    {
        return $this->hasOne(Product::class);
    }
}
