<?php

namespace App\Modules\Department\Contracts;

use App\Modules\Department\Models\Department;

interface DepartmentRepositoryInterface
{
    public function list();
    public function show($id): ?Department;
    public function store(array $data): Department;
    public function update(Department $department, array $data): Department;
    public function destroy(Department $department): bool;
}
