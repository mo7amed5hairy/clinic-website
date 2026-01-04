<?php

namespace App\Modules\SocialMedia\Repositories;

use App\Modules\SocialMedia\Contracts\SocialMediaRepositoryInterface;
use App\Modules\SocialMedia\Models\SocialMedia;

class SocialMediaRepository implements SocialMediaRepositoryInterface
{
    public function findByClinicId(int $clinicId): ?SocialMedia
    {
        return SocialMedia::where('clinic_id', $clinicId)->first();
    }

    public function find(int $id): ?SocialMedia
    {
        return SocialMedia::find($id);
    }

    public function create(array $data): SocialMedia
    {
        return SocialMedia::create($data);
    }

    public function update(SocialMedia $social, array $data): SocialMedia
    {
        $social->update($data);
        return $social;
    }

    public function delete(SocialMedia $social): bool
    {
        return $social->delete();
    }
}
