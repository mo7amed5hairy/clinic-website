<?php

namespace App\Modules\Appointment\Services;

use App\Modules\Appointment\Contracts\AppointmentRepositoryInterface;

class AppointmentService
{
    public function __construct(
        protected AppointmentRepositoryInterface $repo
    ) {}

    public function list(string $tenantId)
    {
        return $this->repo->allByTenant($tenantId);
    }

    public function show(int $id)
    {
        return $this->repo->find($id);
    }

    public function store(array $data)
    {
        return $this->repo->create($data);
    }

    public function update(int $id, array $data)
    {
        $appointment = $this->repo->find($id);
        return $this->repo->update($appointment, $data);
    }

    public function delete(int $id): bool
    {
        $appointment = $this->repo->find($id);
        return $this->repo->delete($appointment);
    }
}
