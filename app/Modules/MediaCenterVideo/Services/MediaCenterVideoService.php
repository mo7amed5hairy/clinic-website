<?php

namespace App\Modules\MediaCenterVideo\Services;

use App\Modules\MediaCenterVideo\Contracts\MediaCenterVideoRepositoryInterface;
use App\Modules\MediaCenterVideo\Models\MediaCenterVideo;

class MediaCenterVideoService
{
    public function __construct(
        protected MediaCenterVideoRepositoryInterface $repository
    ) {}

    public function getByClinicId(int $clinicId)
    {
        return $this->repository->getByClinicId($clinicId);
    }

    public function find(int $id): ?MediaCenterVideo
    {
        return $this->repository->find($id);
    }

    public function createOrUpdate(int $clinicId, array $data): MediaCenterVideo
    {
        if (isset($data['id'])) {
            $video = $this->repository->find($data['id']);
            if (!$video || $video->clinic_id != $clinicId) {
                throw new \Exception(__('MediaCenterVideo/messages.errors.not_found'));
            }
            return $this->repository->update($video, $data);
        }

        return $this->repository->create(array_merge($data, ['clinic_id' => $clinicId]));
    }

    public function destroy(MediaCenterVideo $video): bool
    {
        return $this->repository->delete($video);
    }
}
