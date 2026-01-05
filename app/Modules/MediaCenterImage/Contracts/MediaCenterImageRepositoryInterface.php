<?php

namespace App\Modules\MediaCenterImage\Contracts;

use App\Modules\MediaCenterImage\Models\MediaCenterImage;

interface MediaCenterImageRepositoryInterface
{
    public function getByClinicId(int $clinicId);
    public function find(int $id): ?MediaCenterImage;
    public function create(array $data): MediaCenterImage;
    public function update(MediaCenterImage $image, array $data): MediaCenterImage;
    public function delete(MediaCenterImage $image): bool;
}
