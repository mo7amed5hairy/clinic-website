<?php

namespace App\Modules\ContactInfo\Services;

use App\Modules\ContactInfo\Contracts\ContactInfoRepositoryInterface;
use App\Modules\ContactInfo\Models\ContactInfo;

class ContactInfoService
{
    public function __construct(
        protected ContactInfoRepositoryInterface $repository
    ) {}

    public function getByClinicId(int $clinicId): ?ContactInfo
    {
        return $this->repository->findByClinicId($clinicId);
    }

    public function createOrUpdate(int $clinicId, array $data): ContactInfo
    {
        $info = $this->repository->findByClinicId($clinicId);

        if ($info) {
            return $this->repository->update($info, $data);
        }

        return $this->repository->create(array_merge($data, ['clinic_id' => $clinicId]));
    }

    public function destroy(ContactInfo $info): bool
    {
        return $this->repository->delete($info);
    }
}
