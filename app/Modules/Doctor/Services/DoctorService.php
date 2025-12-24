<?php

namespace App\Modules\Doctor\Services;

use App\Modules\Doctor\Contracts\DoctorRepositoryInterface;
use App\Modules\Doctor\Models\Doctor;

class DoctorService
{
    public function __construct(
        protected DoctorRepositoryInterface $repository
    ) {}

    public function list(int $perPage = 15)
    {
        return $repository = $this->repository->paginate($perPage);
    }

    public function show(int $id): Doctor
    {
        return $this->repository->find($id)
            ?? throw new \Exception(__('doctor.not_found'));
    }

    public function store(array $data): Doctor
    {
        return $this->repository->create($data);
    }

    public function update(Doctor $doctor, array $data): Doctor
    {
        return $this->repository->update($doctor, $data);
    }

    public function destroy(Doctor $doctor): bool
    {
        return $this->repository->delete($doctor);
    }
}
