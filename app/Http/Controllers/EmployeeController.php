<?php

namespace App\Http\Controllers;

use App\Repositories\Employee\EmployeeRepository;
use App\Data\EmployeeData;
use App\Models\Employee;

class EmployeeController extends Controller
{

    public function __construct(private EmployeeRepository $employees) {}

    public function index()
    {
        return EmployeeData::collect($this->employees->all());
    }

    public function show(Employee $employee)
    {
        return $this->employees->findById($employee->id);
    }

    public function store(EmployeeData $employeeData)
    {
        return $this->employees->create($employeeData);
    }

    public function update(Employee $employee, EmployeeData $employeeData)
    {
        return $this->employees->update($employee->id, $employeeData);
    }

    public function destroy($id)
    {
        return $this->employees->delete($id);
    }
}
