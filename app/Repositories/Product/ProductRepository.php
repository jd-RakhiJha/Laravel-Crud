<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Data\ProductData;

class ProductRepository implements ProductRepositoryInterface
{
    public function all()
    {
        return Product::all();
    }

    public function findById($id)
    {
        return Product::findOrFail($id);
    }

    public function create(ProductData $productData)
    {
        // dd($productData->toArray());
        return Product::create($productData->toArray());
    }
    public function update($id, ProductData $productData)
    {
        $product = Product::find($id);
        $product->update($productData->toArray());
        return $product;
    }

    public function delete($id)
    {
        return Product::destroy($id);
    }
}
