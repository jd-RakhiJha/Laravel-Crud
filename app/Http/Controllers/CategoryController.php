<?php

namespace App\Http\Controllers;

use App\Data\CategoryData;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Managers\CategoryManager;
use App\Repositories\Category\CategoryRepository;

class CategoryController extends Controller
{

    public function __construct(
        private CategoryManager $categoryManager,
        private CategoryRepository $Category
    ) {}

    public function index()
    {
        return CategoryData::collect($this->Category->all());
    }

    public function store(CategoryData $categoryData)
    {
        return $this->Category->create($categoryData)->getData();
    }

    public function show($id)
    {
        return $this->categoryManager->getCategoryById($id);
    }

    public function update(CategoryData $categoryData, $id)
    {
        return $this->categoryManager->updateCategory($id, $categoryData);
    }

    public function destroy($id)
    {
        return $this->categoryManager->deleteCategory($id);
    }
}
