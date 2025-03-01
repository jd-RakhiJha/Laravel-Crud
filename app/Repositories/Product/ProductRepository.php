<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Data\ProductData;
use App\Data\ProductCategoryData;


class ProductRepository
{
    public function all()
    {
        return Product::with('categories')->get();
    }

    public function findById($id)
    {
        return Product::with('categories')->findOrFail($id);
    }

    public function create(ProductData $productData)
    {
        return Product::create($productData->toArray());
    }

    public function update(Product $product, ProductData $productData)
    {
        $product->update($productData->toArray());
        return $product;
    }

    public function delete($id)
    {
        return Product::destroy($id);
    }

    public function attachCategories(Product $product, ProductCategoryData $data)
    {
        return $product->categories()->sync($data->category_ids);
    }
}
