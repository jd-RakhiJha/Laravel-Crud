<?php

namespace App\Http\Controllers;

use App\Data\CategoryData;
use App\Models\Category;
use App\Managers\CategoryManager;
use App\Repositories\Category\CategoryRepository;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryManager $categoryManager,
        private CategoryRepository $category
    ) {}

    public function index()
    {
        return CategoryData::collect($this->categoryManager->getAllCategory());
    }

    public function store(CategoryData $categoryData)
    {
        return $this->category->create($categoryData);
    }

    public function show(Category $category)
    {
        return $this->category->findById($category);
    }

    public function update(Category $id, CategoryData $categoryData)
    {
        return $this->category->update($id, $categoryData);
    }

    public function destroy(Category $category)
    {
        return $this->category->delete($category);
    }
}
