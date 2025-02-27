<?php

namespace App\Http\Controllers;

use App\Data\ProductData;
use App\Models\Product;
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
        return ProductData::collect($this->productManager->all());
    }

    public function store(ProductData $productData)
    {
        return $this->products->create($productData);
    }

    public function show(Product $product)
    {
        return $this->products->findById($product);
    }

    public function update(Product $id, ProductData $productData)
    {
        return $this->products->update($id, $productData);
    }

    public function destroy($id)
    {
        return $this->products->delete($id);
    }
}
