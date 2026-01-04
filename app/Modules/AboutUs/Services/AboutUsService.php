<?php

namespace App\Modules\AboutUs\Services;

use App\Modules\AboutUs\Contracts\AboutUsRepositoryInterface;
use App\Modules\AboutUs\Models\AboutUs;

class AboutUsService
{
    public function __construct(
        protected AboutUsRepositoryInterface $repository
    ) {}

    public function getByClinicId(int $clinicId): ?AboutUs
    {
        return $this->repository->findByClinicId($clinicId);
    }

    public function createOrUpdate(int $clinicId, array $data): AboutUs
    {
        $aboutUs = $this->repository->findByClinicId($clinicId);

        if ($aboutUs) {
            return $this->repository->update($aboutUs, $data);
        }

        return $this->repository->create(array_merge($data, ['clinic_id' => $clinicId]));
    }

    public function destroy(AboutUs $aboutUs): bool
    {
        return $this->repository->delete($aboutUs);
    }
}
