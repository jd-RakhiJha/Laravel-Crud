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
        return view('products.index', ['products' => $this->productManager->getAllProducts()]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(ProductData $productData)
    {
        $this->products->create($productData); 
        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function show($id)
    {
        return view('products.show', ['product' => $this->productManager->getProductById($id)]);
    }

    public function edit($id)
    {
        return view('products.edit', ['product' => $this->productManager->getProductById($id)]);
    }

    public function update(ProductData $productData, $id)
    {
        $this->productManager->updateProduct($id, $productData); 
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $this->productManager->deleteProduct($id);
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
