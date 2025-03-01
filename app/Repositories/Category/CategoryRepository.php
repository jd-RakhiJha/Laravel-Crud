<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Data\CategoryData;


class CategoryRepository
{

    public function all()
    {
        return Category::with('products')->get();
    }

    public function findById($id)
    {
        return Category::with('products')->findOrFail($id);
    }

    public function create(CategoryData $categoryData)
    {
        return Category::create($categoryData->toArray());
    }

    public function update($id, CategoryData $categoryData)
    {
        $category = Category::findOrFail($id);
        $category->update($categoryData->toArray());
        return $category;
    }

    public function delete($id)
    {
        return Category::destroy($id);
    }

    public function attachProducts(Category $category, array $productIds)
    {
        return $category->products()->sync($productIds);
    }
}
