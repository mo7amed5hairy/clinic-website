<?php

namespace App\Modules\WhyUs\Services;

use App\Modules\WhyUs\Contracts\WhyUsRepositoryInterface;
use App\Modules\WhyUs\Models\WhyUs;

class WhyUsService
{
    public function __construct(
        protected WhyUsRepositoryInterface $repository
    ) {}

    public function getByClinicId(int $clinicId): ?WhyUs
    {
        return $this->repository->findByClinicId($clinicId);
    }

    public function createOrUpdate(int $clinicId, array $data): WhyUs
    {
        $whyUs = $this->repository->findByClinicId($clinicId);

        if ($whyUs) {
            return $this->repository->update($whyUs, $data);
        }

        return $this->repository->create(array_merge($data, ['clinic_id' => $clinicId]));
    }

    public function destroy(WhyUs $whyUs): bool
    {
        return $this->repository->delete($whyUs);
    }
}
