<?php

namespace App\Http\Controllers;

use App\Data\ProductData;
use App\Models\Product;
use App\Managers\ProductManager;

class ProductController extends Controller
{
    public function __construct(
        private ProductManager $productManager
    ) {}

    public function index()
    {
        return ProductData::collect($this->productManager->getAllProducts());
    }

    public function store(ProductData $productData)
    {
        return $this->productManager->createProduct($productData);
    }

    public function show(Product $product)
    {
        return $this->productManager->getProductById($product);
    }

    public function update(Product $product, ProductData $productData)
    {
        return $this->productManager->updateProduct($product, $productData);
    }

    public function destroy(Product $product)
    {
        return $this->productManager->deleteProduct($product);
    }
}
