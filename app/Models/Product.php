<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\WithData;

class Product extends Model
{
    use HasFactory, WithData;


    protected $table = 'product_models';

    protected $fillable = ['name', 'price', 'description'];
}
