<?php

namespace App\Http\Controllers;

use App\Data\ProductData;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;

class ProductController extends Controller
{
    public function __construct(
        private ProductRepository $products
    ) {}

    public function index()
    {
        return ProductData::collect($this->products->all());
    }

    public function store(ProductData $productData)
    {
        return $this->products->create($productData);
    }

    public function show(Product $product)
    {
        return $this->products->findById($product->id);
    }

    public function update(Product $product, ProductData $productData)
    {
        return $this->products->update($product, $productData);
    }

    public function destroy(Product $product)
    {
        return $this->products->delete($product);
    }
}
