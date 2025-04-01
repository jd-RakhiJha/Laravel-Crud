<?php

namespace App\Repositories;;

use Illuminate\Support\Collection;
use App\Models\Classes;
use App\Data\ClassesData;



class ClassesRepository
{
    public function all(): Collection
    {
        return Classes::all();
    }

    public function findById(int $id): ?Classes
    {
        return Classes::find($id);
    }

    public function create(ClassesData $classesData): Classes
    {
        return Classes::create($classesData->toArray());
    }

    public function update(Classes $class, ClassesData $classData): Classes
    {
        $class->update($classData->toArray());
        return $class;
    }

    public function delete(int $id): bool
    {
        return Classes::destroy($id);
    }
}
