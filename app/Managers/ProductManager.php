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

    public function getAllProducts()
    {
        return $this->productRepository->all();
    }

    public function getProductById(Product $product)
    {
        return $this->productRepository->findById($product->id);
    }

    public function createProduct(ProductData $productData)
    {
        return $this->productRepository->create($productData);
    }

    public function updateProduct(Product $product, ProductData $productData)
    {
        return $this->productRepository->update($product->id, $productData);
    }

    public function deleteProduct(Product $product)
    {
        return $this->productRepository->delete($product->id);
    }
}
