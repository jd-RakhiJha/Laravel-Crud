<?php

namespace App\Managers;

use App\Repositories\Product\ProductRepository;
use App\Data\ProductData;
use App\Models\Product;

class ProductManager
{
    protected ProductRepository $products;

    public function __construct()
    {
        $this->products = new ProductRepository;
    }
}
