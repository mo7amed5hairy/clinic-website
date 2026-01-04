<?php

namespace App\Modules\Mission\Contracts;

use App\Modules\Mission\Models\Mission;

interface MissionRepositoryInterface
{
    public function findByClinicId(int $clinicId): ?Mission;
    public function find(int $id): ?Mission;
    public function create(array $data): Mission;
    public function update(Mission $mission, array $data): Mission;
    public function delete(Mission $mission): bool;
}
