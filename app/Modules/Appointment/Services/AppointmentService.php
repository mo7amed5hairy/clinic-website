<?php

namespace App\Modules\Appointment\Services;

use App\Modules\Appointment\Contracts\AppointmentRepositoryInterface;
use App\Modules\Appointment\Models\Appointment;

class AppointmentService
{
    public function __construct(
        protected AppointmentRepositoryInterface $repository
    ) {}

    public function all()
    {
        return $this->repository->all();
    }

    public function show(int $id): ?Appointment
    {
        return $this->repository->find($id);
    }

    public function create(array $data): Appointment
    {
        return $this->repository->create($data);
    }

    public function destroy(Appointment $appointment): bool
    {
        return $this->repository->delete($appointment);
    }
}
