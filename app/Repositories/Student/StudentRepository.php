<?php

namespace App\Repositories\Student;

use App\Models\Student;
use App\Data\StudentData;

class StudentRepository
{

    public function all()
    {
        return Student::all();
    }

    public function findById($id)
    {
        return Student::find($id);
    }

    public function create(StudentData $studentData)
    {
        return Student::create($studentData->toArray());
    }

    public function update(Student $student, StudentData $studentData)
    {
        $student->update($studentData->toArray());

        return $student;
    }

    public function delete($id)
    {
        return Student::destroy($id);
    }
}
