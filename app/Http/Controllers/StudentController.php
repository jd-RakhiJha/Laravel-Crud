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

    public function index()
    {
        // return Inertia::render('Students/Index', [
        //     'students' => $this->students->all(),
        // ]);
        // return $this->students->all();
        return $this->students->allWithFilter();
    }

    public function allWithFilter()
    {
        return Inertia::render('Students/Index', [
            'students' => $this->students->allWithFilter(request()->all()),
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
