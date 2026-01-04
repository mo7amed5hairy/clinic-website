<?php

namespace App\Modules\Vision\Repositories;

use App\Modules\Vision\Contracts\VisionRepositoryInterface;
use App\Modules\Vision\Models\Vision;

class VisionRepository implements VisionRepositoryInterface
{
    public function findByClinicId(int $clinicId): ?Vision
    {
        return Vision::where('clinic_id', $clinicId)->first();
    }

    public function find(int $id): ?Vision
    {
        return Vision::find($id);
    }

    public function create(array $data): Vision
    {
        return Vision::create($data);
    }

    public function update(Vision $vision, array $data): Vision
    {
        $vision->update($data);
        return $vision;
    }

    public function delete(Vision $vision): bool
    {
        return $vision->delete();
    }
}
