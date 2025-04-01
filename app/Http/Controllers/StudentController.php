<?php

namespace App\Http\Controllers;

use App\Data\StudentData;
use App\Http\Requests\StudentRequest;
use App\Models\Student;
use App\Repositories\Student\StudentRepository;
use Inertia\Inertia;
use Inertia\Response;

class StudentController extends Controller
{
    public function __construct(protected StudentRepository $students) {}

    public function index(): Response
    {
        return Inertia::render('Students/Index', [
            'students' => $this->students->all(),
        ]);
    }

    public function store(StudentData $studentData)
    {
        return $this->students->create($studentData);
    }

    public function update(StudentData $studentData, Student $student)
    {
        return $this->students->update($student, $studentData);
    }

    public function destroy(Student $student)
    {
        return $this->students->delete($student->id);
    }
}
