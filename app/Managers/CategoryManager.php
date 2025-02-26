<?php

namespace App\Managers;

use App\Repositories\Category\CategoryRepository;
use App\Data\CategoryData;


class  CategoryManager
{

    protected $categories;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categories = $categoryRepository;
    }

    public function getAllCategory()
    {
        return $this->categories->all();
    }

    public function getCategoryById($id)
    {
        return $this->categories->findById($id);
    }

    public function createCategory(CategoryData $categoryData)
    {
        return $this->categories->create($categoryData);
    }

    public function updateCategory($id, CategoryData $categoryData)
    {
        return $this->categories->update($id, $categoryData);
    }

    public function deleteCategory($id)
    {
        return $this->categories->delete($id);
    }
}
