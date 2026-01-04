<?php

namespace App\Modules\Doctor\Contracts;

use App\Modules\Doctor\Models\Doctor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface DoctorRepositoryInterface
{
    public function getByClinicId(int $clinicId);

    public function find(int $id): ?Doctor;

    public function create(array $data): Doctor;

    public function update(Doctor $doctor, array $data): Doctor;

    public function delete(Doctor $doctor): bool;
}
