<?php

namespace App\Modules\ContactInfo\Contracts;

use App\Modules\ContactInfo\Models\ContactInfo;

interface ContactInfoRepositoryInterface
{
    public function findByClinicId(int $clinicId): ?ContactInfo;
    public function find(int $id): ?ContactInfo;
    public function create(array $data): ContactInfo;
    public function update(ContactInfo $info, array $data): ContactInfo;
    public function delete(ContactInfo $info): bool;
}
