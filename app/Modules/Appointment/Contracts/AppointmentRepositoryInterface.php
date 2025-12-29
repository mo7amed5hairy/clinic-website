<?php

namespace App\Modules\Appointment\Contracts;

use App\Modules\Appointment\Models\Appointment;

interface AppointmentRepositoryInterface
{
    public function allByTenant(string $tenantId);
    public function find(int $id): ?Appointment;
    public function create(array $data): Appointment;
    public function update(Appointment $appointment, array $data): Appointment;
    public function delete(Appointment $appointment): bool;
}
