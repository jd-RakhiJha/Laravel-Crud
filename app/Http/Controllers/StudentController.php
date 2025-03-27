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
            'students' => $this->students->all()
        ]);
    }

    public function store(StudentRequest $request)
    {
        $this->students->create($request->validated());
        return redirect()->back();
    }

    public function update(StudentRequest $request, $id)
    {
        $this->students->update($id, $request->validated());
        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->students->delete($id);
        return redirect()->back();
    }
}
