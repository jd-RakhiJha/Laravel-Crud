<?php

namespace App\Managers;

use App\Repositories\Product\ProductRepository;
use App\Data\ProductData;
use App\Models\Product;

class ProductManager
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function all()
    {
        return $this->productRepository->all();
    }

    public function store(ProductData $productData)
    {
        return $this->productRepository->create($productData);
    }

    public function update(Product $product, ProductData $productData)
    {
        return $this->productRepository->update($product->id, $productData);
    }

    public function delete($id)
    {
        return $this->productRepository->delete($id);
    }
}
