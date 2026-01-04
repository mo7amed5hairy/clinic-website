<?php

namespace App\Modules\ClinicNews\Services;

use App\Modules\ClinicNews\Contracts\ClinicNewsRepositoryInterface;
use App\Modules\ClinicNews\Models\ClinicNews;

class ClinicNewsService
{
    public function __construct(
        protected ClinicNewsRepositoryInterface $repository
    ) {}

    public function getByClinicId(int $clinicId)
    {
        return $this->repository->getByClinicId($clinicId);
    }

    public function show(int $id): ?ClinicNews
    {
        return $this->repository->find($id);
    }

    public function createOrUpdate(int $clinicId, array $data): ClinicNews
    {
        if (isset($data['id'])) {
            $news = $this->repository->find($data['id']);
            if (!$news || $news->clinic_id != $clinicId) {
                throw new \Exception("News item not found or unauthorized");
            }
            return $this->repository->update($news, $data);
        }

        return $this->repository->create(array_merge($data, ['clinic_id' => $clinicId]));
    }

    public function destroy(ClinicNews $news): bool
    {
        return $this->repository->delete($news);
    }
}
