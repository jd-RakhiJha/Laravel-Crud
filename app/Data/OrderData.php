<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class OrderData extends Data
{
    public function __construct(
        public ?int $user_id,
        public string $order_number,
        public float $total_price
    ) {}
}
