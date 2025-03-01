<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;

class ProductCategoryData extends Data
{
    #[Required, IntegerType, Exists('products', 'id')]
    public int $product_id;

    #[Required, ArrayType, Exists('categories', 'id')]
    public array $category_ids;
}
