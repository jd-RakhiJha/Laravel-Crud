<?php

namespace App\Http\Controllers;

use App\Data\CategoryData;
use App\Models\Category;
use App\Managers\CategoryManager;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryManager $categoryManager
    ) {}

    public function index()
    {
        return CategoryData::collect($this->categoryManager->getAllCategory());
    }

    public function store(CategoryData $categoryData)
    {
        return $this->categoryManager->createCategory($categoryData);
    }

    public function show(Category $category)
    {
        return $this->categoryManager->getCategoryById($category);
    }

    public function update(Category $category, CategoryData $categoryData)
    {
        return $this->categoryManager->updateCategory($category, $categoryData);
    }

    public function destroy(Category $category)
    {
        return $this->categoryManager->deleteCategory($category);
    }
}
