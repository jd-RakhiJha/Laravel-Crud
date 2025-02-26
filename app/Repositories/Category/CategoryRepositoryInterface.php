<?php

namespace App\Repositories\Category;

use App\Data\CategoryData;

interface CategoryRepositoryInterface
{

    public function all();

    public function findById($id);

    public function create(CategoryData $data);

    public function update($id, CategoryData $data);

    public function delete($id);
}
