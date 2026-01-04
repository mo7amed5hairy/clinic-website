<?php

namespace App\Modules\WhyUs\Repositories;

use App\Modules\WhyUs\Contracts\WhyUsRepositoryInterface;
use App\Modules\WhyUs\Models\WhyUs;

class WhyUsRepository implements WhyUsRepositoryInterface
{
    public function findByClinicId(int $clinicId): ?WhyUs
    {
        return WhyUs::where('clinic_id', $clinicId)->first();
    }

    public function find(int $id): ?WhyUs
    {
        return WhyUs::find($id);
    }

    public function create(array $data): WhyUs
    {
        return WhyUs::create($data);
    }

    public function update(WhyUs $whyUs, array $data): WhyUs
    {
        $whyUs->update($data);
        return $whyUs;
    }

    public function delete(WhyUs $whyUs): bool
    {
        return $whyUs->delete();
    }
}
