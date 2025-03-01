<?php

namespace App\Repositories\Employee;

use App\Models\Employee;
use  App\Data\EmployeeData;

class EmployeeRepository
{
    public function all()
    {
        return Employee::all();
    }

    public function findById($id)
    {
        return Employee::findOrFail($id);
    }

    public function create(EmployeeData $employeeData)
    {
        return Employee::create($employeeData->toArray());
        return $employee->toArray();
    }

    public function update(Employee $employee, EmployeeData $data)
    {
        $employee->update($data->toArray());
        return $employee;
    }

    public function delete($id)
    {
        return Employee::destroy($id);
    }
}
