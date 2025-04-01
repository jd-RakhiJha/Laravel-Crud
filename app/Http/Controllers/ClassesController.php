<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Data\ClassesData;
use App\Models\Classes;

use App\Repositories\ClassesRepository;

class ClassesController extends Controller
{
    public function __construct(protected ClassesRepository $classes) {}

    public function index()
    {
        return ClassesData::collect($this->getAllContacts());
    }

    public function store(ClassesData $classesData)
    {
        return $this->classes->create($classesData);
    }

    public function update(ClassesData $classesData, Classes $classes)
    {
        return $this->classes->update($classes, $classesData);
    }

    public function destroy(Classes $classes)
    {
        return $this->classes->delete($classes->id);
    }
}
