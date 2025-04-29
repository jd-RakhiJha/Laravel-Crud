<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class InventoryData extends Data
{
    public function __construct(
        public string $name,
        public ?string $description,
        public int $quantity,
        public float $unit_price,
        public int $category_id,
        public int $minimum_stock,
        public string $location,
        public string $status,
        public ?string $last_restock_date = null,
        public ?int $last_restock_quantity = null,
        public ?string $inventoryable_type = null,
        public ?int $inventoryable_id = null
    ) {}
}
