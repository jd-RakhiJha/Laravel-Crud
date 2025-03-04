<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Data\CategoryData;
use Illuminate\Support\Collection;

class CategoryRepository
{

    public function all(): Collection
    {
        return Category::all();
    }

    public function findById(int $id): ?Category
    {
        return Category::find($id);
    }

    public function create(CategoryData $categoryData): Category
    {
        return Category::create($categoryData->toArray());
    }

    public function update(Category $category, CategoryData $categoryData): Category
    {
        $category->update($categoryData->toArray());
        return $category;
    }

    public function delete($id): bool
    {
        return Category::destroy($id);
    }
}
