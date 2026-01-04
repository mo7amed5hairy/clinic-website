<?php

namespace App\Modules\AboutUs\Repositories;

use App\Modules\AboutUs\Contracts\AboutUsRepositoryInterface;
use App\Modules\AboutUs\Models\AboutUs;

class AboutUsRepository implements AboutUsRepositoryInterface
{
    public function findByClinicId(int $clinicId): ?AboutUs
    {
        return AboutUs::where('clinic_id', $clinicId)->first();
    }

    public function find(int $id): ?AboutUs
    {
        return AboutUs::find($id);
    }

    public function create(array $data): AboutUs
    {
        return AboutUs::create($data);
    }

    public function update(AboutUs $aboutUs, array $data): AboutUs
    {
        $aboutUs->update($data);
        return $aboutUs;
    }

    public function delete(AboutUs $aboutUs): bool
    {
        return $aboutUs->delete();
    }
}
