<?php

namespace App\Http\Controllers;

use App\Data\CategoryData;
use App\Models\Category;
use App\Repositories\Category\CategoryRepository;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryRepository $categories
    ) {}

    public function index()
    {
        return CategoryData::collect($this->categories->all());
    }

    public function store(CategoryData $categoriesData)
    {
        return $this->categories->create($categoriesData);
    }

    public function show(Category $categories)
    {
        return $this->categories->findById($categories->id);
    }

    public function update(Category $categories, CategoryData $categoriesData)
    {
        return $this->categories->update($categories, $categoriesData);
    }

    public function destroy(Category $categories)
    {
        return $this->categories->delete($categories);
    }
}
