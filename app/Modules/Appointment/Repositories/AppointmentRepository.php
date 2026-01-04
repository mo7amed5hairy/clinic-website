<?php

namespace App\Modules\Appointment\Repositories;

use App\Modules\Appointment\Contracts\AppointmentRepositoryInterface;
use App\Modules\Appointment\Models\Appointment;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function all()
    {
        return Appointment::all();
    }

    public function find(int $id): ?Appointment
    {
        return Appointment::find($id);
    }

    public function create(array $data): Appointment
    {
        return Appointment::create($data);
    }

    public function delete(Appointment $appointment): bool
    {
        return $appointment->delete();
    }
}
