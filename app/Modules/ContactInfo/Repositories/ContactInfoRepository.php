<?php

namespace App\Modules\ContactInfo\Repositories;

use App\Modules\ContactInfo\Contracts\ContactInfoRepositoryInterface;
use App\Modules\ContactInfo\Models\ContactInfo;

class ContactInfoRepository implements ContactInfoRepositoryInterface
{
    public function findByClinicId(int $clinicId): ?ContactInfo
    {
        return ContactInfo::where('clinic_id', $clinicId)->first();
    }

    public function find(int $id): ?ContactInfo
    {
        return ContactInfo::find($id);
    }

    public function create(array $data): ContactInfo
    {
        return ContactInfo::create($data);
    }

    public function update(ContactInfo $info, array $data): ContactInfo
    {
        $info->update($data);
        return $info;
    }

    public function delete(ContactInfo $info): bool
    {
        return $info->delete();
    }
}
