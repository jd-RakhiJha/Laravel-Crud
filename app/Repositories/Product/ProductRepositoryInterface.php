<?php

namespace App\Repositories\Product;

use App\Data\ProductData;

interface ProductRepositoryInterface
{
    public function all();
    public function findById($id);
    public function create(ProductData $data);
    public function update($id, ProductData $data);
    public function delete($id);
}
