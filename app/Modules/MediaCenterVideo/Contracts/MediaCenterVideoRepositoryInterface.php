<?php

namespace App\Modules\MediaCenterVideo\Contracts;

use App\Modules\MediaCenterVideo\Models\MediaCenterVideo;

interface MediaCenterVideoRepositoryInterface
{
    public function getByClinicId(int $clinicId);
    public function find(int $id): ?MediaCenterVideo;
    public function create(array $data): MediaCenterVideo;
    public function update(MediaCenterVideo $video, array $data): MediaCenterVideo;
    public function delete(MediaCenterVideo $video): bool;
}
