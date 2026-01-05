<?php

namespace App\Modules\MediaCenterImage\Services;

use App\Modules\MediaCenterImage\Contracts\MediaCenterImageRepositoryInterface;
use App\Modules\MediaCenterImage\Models\MediaCenterImage;

class MediaCenterImageService
{
    public function __construct(
        protected MediaCenterImageRepositoryInterface $repository
    ) {}

    public function getByClinicId(int $clinicId)
    {
        return $this->repository->getByClinicId($clinicId);
    }

    public function find(int $id): ?MediaCenterImage
    {
        return $this->repository->find($id);
    }

    public function createOrUpdate(int $clinicId, array $data): MediaCenterImage
    {
        if (isset($data['id'])) {
            $image = $this->repository->find($data['id']);
            if (!$image || $image->clinic_id != $clinicId) {
                throw new \Exception(__('MediaCenterImage/messages.errors.not_found'));
            }
            return $this->repository->update($image, $data);
        }

        return $this->repository->create(array_merge($data, ['clinic_id' => $clinicId]));
    }

    public function destroy(MediaCenterImage $image): bool
    {
        return $this->repository->delete($image);
    }
}
