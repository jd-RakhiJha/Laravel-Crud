<?php

namespace App\Repositories\Student;

use App\Models\Student;
use App\Data\StudentData;
use Illuminate\Support\Collection;

class StudentRepository
{

    public function all(): Collection
    {
        return Student::all();
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
