<?php

namespace App\Modules\Department\Repositories;

use App\Modules\Department\Contracts\DepartmentRepositoryInterface;
use App\Modules\Department\Models\Department;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function list()
    {
        return Department::all();
    }

    public function show($id): ?Department
    {
        return Department::find($id);
    }

    public function store(array $data): Department
    {
        return Department::create($data);
    }

    public function update(Department $department, array $data): Department
    {
        $department->update($data);
        return $department;
    }

    public function destroy(Department $department): bool
    {
        return $department->delete();
    }
}
