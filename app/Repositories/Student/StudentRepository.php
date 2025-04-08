<?php

namespace App\Repositories\Student;

use App\Models\Student;
use App\Data\StudentData;
use App\Models\Classes;
use Illuminate\Support\Collection;

class StudentRepository
{

    public function all($perPage)
    {
        return Student::filter()->with(['class', 'section'])->paginate($perPage)->withQueryString();
    }
    public function classes_with_sections()
    {
        return Classes::with('sections')->get()->map(function ($class) {
            return [
                'id' => $class->id,
                'name' => $class->name,
                'sections' => $class->sections->map(function ($section) {
                    return [
                        'id' => $section->id,
                        'name' => $section->name,
                    ];
                }),
            ];
        });
    }


    public function findById(int $id): ?Student
    {
        return Student::find($id);
    }

    public function create(StudentData $studentData): Student
    {
        return Student::create($studentData->toArray());
    }

    public function update(Student $student, StudentData $studentData): Student
    {
        $student->update($studentData->toArray());
        return $student;
    }

    public function delete($id): bool
    {
        return Student::destroy($id);
    }
}
