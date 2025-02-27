<?php

namespace App\Managers;

use App\Repositories\Category\CategoryRepository;
use App\Data\CategoryData;
use App\Models\Category;

class CategoryManager
{
    protected CategoryRepository $categories;

    public function __construct()
    {
        $this->categories = new CategoryRepository;
    }
}
