<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Support\Collection;
use App\Data\ProductData;


class ProductRepository
{
    public function all(): Collection
    {
        return Product::all();
    }

    public function findById(int $id): ?Product
    {
        return Product::find($id);
    }

    public function create(ProductData $productData): Product
    {
        return Product::create($productData->toArray());
    }

    public function update(Product $product, ProductData $productData): Product
    {
        $product->update($productData->toArray());
        return $product;
    }

    public function delete($id): bool
    {
        return Product::destroy($id);
    }
}
