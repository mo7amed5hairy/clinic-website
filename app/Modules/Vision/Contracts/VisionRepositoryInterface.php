<?php

namespace App\Modules\Vision\Contracts;

use App\Modules\Vision\Models\Vision;

interface VisionRepositoryInterface
{
    public function findByClinicId(int $clinicId): ?Vision;
    public function find(int $id): ?Vision;
    public function create(array $data): Vision;
    public function update(Vision $vision, array $data): Vision;
    public function delete(Vision $vision): bool;
}
