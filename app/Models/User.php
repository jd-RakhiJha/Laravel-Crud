<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\LaravelData\WithData;

class User extends Authenticatable
{
    use HasFactory, WithData;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $casts = [
        'email' => 'string',
        'name'  => 'string',
        'password'=>'string',
    ];

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
