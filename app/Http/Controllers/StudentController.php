<?php

namespace App\Http\Controllers;

use App\Data\StudentData;
use App\Models\Student;
use App\Repositories\Student\StudentRepository;

class StudentController extends Controller
{
    public function __construct(
        private StudentRepository $students
    ) {}

    public function index()
    {
        return StudentData::collect($this->students->all());
    }

    public function store(StudentData $studentData)
    {
        return $this->students->create($studentData);
    }

    public function show(Student $student)
    {
        return $this->students->findById($student->id);
    }

    public function update(Student $student, StudentData $studentData)
    {
        return $this->students->update($student, $studentData);
    }

    public function destroy(Student $student)
    {
        return $this->students->delete($student);
    }
}
