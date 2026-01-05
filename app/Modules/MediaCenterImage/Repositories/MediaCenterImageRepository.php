<?php

namespace App\Modules\MediaCenterImage\Repositories;

use App\Modules\MediaCenterImage\Contracts\MediaCenterImageRepositoryInterface;
use App\Modules\MediaCenterImage\Models\MediaCenterImage;

class MediaCenterImageRepository implements MediaCenterImageRepositoryInterface
{
    public function getByClinicId(int $clinicId)
    {
        return MediaCenterImage::where('clinic_id', $clinicId)->get();
    }

    public function find(int $id): ?MediaCenterImage
    {
        return MediaCenterImage::find($id);
    }

    public function create(array $data): MediaCenterImage
    {
        return MediaCenterImage::create($data);
    }

    public function update(MediaCenterImage $image, array $data): MediaCenterImage
    {
        $image->update($data);
        return $image;
    }

    public function delete(MediaCenterImage $image): bool
    {
        return $image->delete();
    }
}
