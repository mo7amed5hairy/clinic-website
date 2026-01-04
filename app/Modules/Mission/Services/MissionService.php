<?php

namespace App\Modules\Mission\Services;

use App\Modules\Mission\Contracts\MissionRepositoryInterface;
use App\Modules\Mission\Models\Mission;

class MissionService
{
    public function __construct(
        protected MissionRepositoryInterface $repository
    ) {}

    public function getByClinicId(int $clinicId): ?Mission
    {
        return $this->repository->findByClinicId($clinicId);
    }

    public function createOrUpdate(int $clinicId, array $data): Mission
    {
        $mission = $this->repository->findByClinicId($clinicId);

        if ($mission) {
            return $this->repository->update($mission, $data);
        }

        return $this->repository->create(array_merge($data, ['clinic_id' => $clinicId]));
    }

    public function destroy(Mission $mission): bool
    {
        return $this->repository->delete($mission);
    }
}
