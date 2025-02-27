<?php

namespace App\Managers;

use App\Repositories\Category\CategoryRepository;
use App\Data\CategoryData;
use App\Models\Category;

class CategoryManager
{
    protected CategoryRepository $categories;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categories = $categoryRepository;
    }

    public function getAllCategory()
    {
        return $this->categories->all();
    }

    public function findById(Category $category)
    {
        return $this->categories->findById($category->id);
    }

    public function create(CategoryData $categoryData)
    {
        return $this->categories->create($categoryData);
    }

    public function update(Category $category, CategoryData $categoryData)
    {
        return $this->categories->update($category->id, $categoryData);
    }

    public function delete(Category $category)
    {
        return $this->categories->delete($category->id);
    }
}
