<?php

namespace App\Modules\Clinic\Services;

use App\Modules\Clinic\Contracts\ClinicRepositoryInterface;
use App\Modules\Clinic\Models\Clinic;

class ClinicService
{
    public function __construct(
        protected ClinicRepositoryInterface $repository
    ) {}

    public function list(int $perPage = 15)
    {
        return $this->repository->paginate($perPage);
    }

    public function show(int $id): ?Clinic
    {
        return $this->repository->find($id);
    }

    public function store(array $data): Clinic
    {
        return $this->repository->create($data);
    }

    public function update(Clinic $clinic, array $data): Clinic
    {
        return $this->repository->update($clinic, $data);
    }

    public function destroy(Clinic $clinic): bool
    {
        return $this->repository->delete($clinic);
    }
}
