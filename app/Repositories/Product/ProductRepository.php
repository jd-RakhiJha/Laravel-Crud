<?php

namespace App\Repositories\Product;

use App\Models\ProductModel;
use App\Data\ProductData;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        return ProductModel::all();
    }

    public function findById($id)
    {
        return ProductModel::findOrFail($id);
    }

    public function create(ProductData $productData)
    {
        return ProductModel::create($productData->toArray());
    }

    public function update($id, ProductData $productData)
    {
        $product = ProductModel::findOrFail($id);
        $product->update($productData->toArray());
        return $product;
    }

    public function delete($id)
    {
        return ProductModel::destroy($id);
    }
}
