<?php

namespace App\Http\Controllers;

use App\Data\ProductData;
use App\Models\Product;
use App\Data\ProductCategoryData;
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
        return $this->products->findById($product);
    }

    public function update(Product $product, ProductData $productData)
    {
        return $this->products->update($product, $productData);
    }

    public function destroy($id)
    {
        return $this->products->delete($id);
    }

    public function attachCategories(ProductCategoryData $data)
    {
        dd('hkdfhlkhglkf');
        $product = $this->products->findById($data->product_id);
        return $this->products->attachCategories($product, $data);
    }
}
