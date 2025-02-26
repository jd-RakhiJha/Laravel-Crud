<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Data\CategoryData;


class CategoryRepository implements CategoryRepositoryInterface
{

    public function all()
    {
        return Category::all();
    }

    public function findById($id)
    {
        return Category::findOrFail($id);
    }

    public function create(CategoryData $categoryData)
    {
        return Category::create($categoryData->toArray());
    }

    public function update($id, CategoryData $categoryData)
    {
        $categoryData = Category::findOrFail($id);
        $categoryData->update($categoryData->toArray());
        return $categoryData;
    }

    public function delete($id)
    {
        return Category::destroy($id);
    }
}
