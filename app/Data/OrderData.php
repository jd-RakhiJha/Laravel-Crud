<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Exists;

class OrderData extends Data
{
    #[Required, IntegerType, Exists('users', 'id')]
    public int $user_id;

    #[Required, StringType]
    public string $order_number;

    #[Required, Numeric]
    public float $total_price;
}
