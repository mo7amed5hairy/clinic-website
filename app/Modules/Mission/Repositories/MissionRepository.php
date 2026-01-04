<?php

namespace App\Modules\Mission\Repositories;

use App\Modules\Mission\Contracts\MissionRepositoryInterface;
use App\Modules\Mission\Models\Mission;

class MissionRepository implements MissionRepositoryInterface
{
    public function findByClinicId(int $clinicId): ?Mission
    {
        return Mission::where('clinic_id', $clinicId)->first();
    }

    public function find(int $id): ?Mission
    {
        return Mission::find($id);
    }

    public function create(array $data): Mission
    {
        return Mission::create($data);
    }

    public function update(Mission $mission, array $data): Mission
    {
        $mission->update($data);
        return $mission;
    }

    public function delete(Mission $mission): bool
    {
        return $mission->delete();
    }
}
