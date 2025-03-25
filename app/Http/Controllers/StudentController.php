<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Repositories\Student\StudentRepository;
use Inertia\Inertia;
use Inertia\Response;

class StudentController extends Controller
{
    public function __construct(protected StudentRepository $students) {}

    public function index(): Response
    {
        return Inertia::render('Students/Index', [
            'students' => $this->studentRepository->all()
        ]);
    }

    public function store(StudentRequest $request)
    {
        $this->studentRepository->create($request->validated());
        return redirect()->back();
    }

    public function update(StudentRequest $request, $id)
    {
        $this->studentRepository->update($id, $request->validated());
        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->studentRepository->delete($id);
        return redirect()->back();
    }
}
