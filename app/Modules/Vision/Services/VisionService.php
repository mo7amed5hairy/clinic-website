<?php

namespace App\Modules\Vision\Services;

use App\Modules\Vision\Contracts\VisionRepositoryInterface;
use App\Modules\Vision\Models\Vision;

class VisionService
{
    public function __construct(
        protected VisionRepositoryInterface $repository
    ) {}

    public function getByClinicId(int $clinicId): ?Vision
    {
        return $this->repository->findByClinicId($clinicId);
    }

    public function createOrUpdate(int $clinicId, array $data): Vision
    {
        $vision = $this->repository->findByClinicId($clinicId);

        if ($vision) {
            return $this->repository->update($vision, $data);
        }

        return $this->repository->create(array_merge($data, ['clinic_id' => $clinicId]));
    }

    public function destroy(Vision $vision): bool
    {
        return $this->repository->delete($vision);
    }
}
