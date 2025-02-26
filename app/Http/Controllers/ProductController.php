<?php

namespace App\Http\Controllers;

use App\Data\ProductData;
use App\Managers\ProductManager;
use App\Repositories\Product\ProductRepository;

class ProductController extends Controller
{
    public function __construct(
        private ProductManager $productManager,
        private ProductRepository $products
    ) {}

    public function index()
    {
        return ProductData::collect($this->products->all());
    }

    public function store(ProductData $productData)
    {
        return $this->products->create($productData)->getData();
    }

    public function show($id)
    {
        return $this->productManager->getProductById($id);
    }

    public function update(ProductData $productData, $id)
    {
        return $this->productManager->updateProduct($id, $productData);
    }

    public function destroy($id)
    {
        return $this->productManager->deleteProduct($id);
    }
}
