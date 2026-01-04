<?php

namespace App\Modules\Doctor\Services;

use App\Modules\Doctor\Contracts\DoctorRepositoryInterface;
use App\Modules\Doctor\Models\Doctor;

class DoctorService
{
    public function __construct(
        protected DoctorRepositoryInterface $repository
    ) {}

    public function getByClinicId(int $clinicId)
    {
        return $this->repository->getByClinicId($clinicId);
    }

    /**
     * يرجع Doctor أو null
     * بدون أي Exceptions
     */
    public function show(int $id): ?Doctor
    {
        return $this->repository->find($id);
    }

    public function createOrUpdate(int $clinicId, array $data): Doctor
    {
        $departments = $data['departments'] ?? [];
        unset($data['departments']); // Remove for model update/create

        if (isset($data['id'])) {
            $doctor = $this->repository->find($data['id']);
            // Check ownership
            if(! $doctor || $doctor->clinic_id != $clinicId) {
                throw new \Exception("Doctor not found or unauthorized");
            }
            $doctor = $this->repository->update($doctor, $data);
        } else {
            $doctor = $this->repository->create(array_merge($data, ['clinic_id' => $clinicId]));
        }

        // Sync Departments
        if (!empty($departments)) {
            $doctor->departments()->delete();
            // Prepend clinic_id to each department
            $deptData = array_map(function($dept) use ($clinicId) {
                $dept['clinic_id'] = $clinicId;
                return $dept;
            }, $departments);
            $doctor->departments()->createMany($deptData);
        }

        return $doctor->refresh();
    }

    public function destroy(Doctor $doctor): bool
    {
        return $this->repository->delete($doctor);
    }
}
