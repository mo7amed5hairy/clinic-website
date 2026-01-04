<?php

namespace App\Modules\SocialMedia\Contracts;

use App\Modules\SocialMedia\Models\SocialMedia;

interface SocialMediaRepositoryInterface
{
    public function findByClinicId(int $clinicId): ?SocialMedia;
    public function find(int $id): ?SocialMedia;
    public function create(array $data): SocialMedia;
    public function update(SocialMedia $social, array $data): SocialMedia;
    public function delete(SocialMedia $social): bool;
}
