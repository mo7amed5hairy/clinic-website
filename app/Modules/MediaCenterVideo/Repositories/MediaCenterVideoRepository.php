<?php

namespace App\Modules\MediaCenterVideo\Repositories;

use App\Modules\MediaCenterVideo\Contracts\MediaCenterVideoRepositoryInterface;
use App\Modules\MediaCenterVideo\Models\MediaCenterVideo;

class MediaCenterVideoRepository implements MediaCenterVideoRepositoryInterface
{
    public function getByClinicId(int $clinicId)
    {
        return MediaCenterVideo::where('clinic_id', $clinicId)->get();
    }

    public function find(int $id): ?MediaCenterVideo
    {
        return MediaCenterVideo::find($id);
    }

    public function create(array $data): MediaCenterVideo
    {
        return MediaCenterVideo::create($data);
    }

    public function update(MediaCenterVideo $video, array $data): MediaCenterVideo
    {
        $video->update($data);
        return $video;
    }

    public function delete(MediaCenterVideo $video): bool
    {
        return $video->delete();
    }
}
