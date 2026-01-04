<?php

namespace App\Modules\Doctor\Repositories;

use App\Modules\Doctor\Contracts\DoctorRepositoryInterface;
use App\Modules\Doctor\Models\Doctor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DoctorRepository implements DoctorRepositoryInterface
{
    public function getByClinicId(int $clinicId)
    {
        return Doctor::where('clinic_id', $clinicId)->with('departments')->get();
    }

    public function find(int $id): ?Doctor
    {
        return Doctor::find($id);
    }

    public function create(array $data): Doctor
    {
        return Doctor::create($data);
    }

    public function update(Doctor $doctor, array $data): Doctor
    {
        $doctor->update($data);
        return $doctor;
    }

    public function delete(Doctor $doctor): bool
    {
        return (bool) $doctor->delete();
    }
}
