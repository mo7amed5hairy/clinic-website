<?php

namespace App\Modules\Department\Services;

use App\Modules\Department\Contracts\DepartmentRepositoryInterface;
use App\Modules\Department\Models\Department;

class DepartmentService
{
    public function __construct(
        protected DepartmentRepositoryInterface $repo
    ) {}

    public function list() {
        return $this->repo->list();
    }

    public function show($id): ?Department {
        return $this->repo->show($id);
    }

    public function store(array $data): Department {
        return $this->repo->store($data);
    }

    public function update(Department $department, array $data): Department {
        return $this->repo->update($department, $data);
    }

    public function destroy(Department $department): bool {
        return $this->repo->destroy($department);
    }
}
