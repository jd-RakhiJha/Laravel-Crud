<?php

namespace App\Repositories\Employee;

use App\Models\Employee;
use  App\Data\EmployeeData;
use Illuminate\Support\Collection;

class EmployeeRepository
{
    public function all(): Collection
    {
        return Employee::all();
    }

    public function findById(int $id): ?Employee
    {
        return Employee::find($id);
    }

    public function create(EmployeeData $employeeData): Employee
    {
        return Employee::create($employeeData->toArray());
    }

    public function update(Employee $employee, EmployeeData $data): Employee
    {
        $employee->update($data->toArray());
        return $employee;
    }

    public function delete($id): bool
    {
        return Employee::destroy($id);
    }
}
