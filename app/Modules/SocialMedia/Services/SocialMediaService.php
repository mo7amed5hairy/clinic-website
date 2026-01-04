<?php

namespace App\Modules\SocialMedia\Services;

use App\Modules\SocialMedia\Contracts\SocialMediaRepositoryInterface;
use App\Modules\SocialMedia\Models\SocialMedia;

class SocialMediaService
{
    public function __construct(
        protected SocialMediaRepositoryInterface $repository
    ) {}

    public function getByClinicId(int $clinicId): ?SocialMedia
    {
        return $this->repository->findByClinicId($clinicId);
    }

    public function createOrUpdate(int $clinicId, array $data): SocialMedia
    {
        $social = $this->repository->findByClinicId($clinicId);

        if ($social) {
            return $this->repository->update($social, $data);
        }

        return $this->repository->create(array_merge($data, ['clinic_id' => $clinicId]));
    }

    public function destroy(SocialMedia $social): bool
    {
        return $this->repository->delete($social);
    }
}
