<?php

namespace App\Managers;

use App\Repositories\Product\ProductRepository;
use App\Data\ProductData;

class ProductManager
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts()
    {
        return $this->productRepository->getAll();
    }

    public function getProductById($id)
    {
        return $this->productRepository->findById($id);
    }

    public function createProduct(ProductData $productData)
    {
        return $this->productRepository->create($productData);
    }

    public function updateProduct($id, ProductData $productData)
    {
        return $this->productRepository->update($id, $productData);
    }

    public function deleteProduct($id)
    {
        return $this->productRepository->delete($id);
    }
}
