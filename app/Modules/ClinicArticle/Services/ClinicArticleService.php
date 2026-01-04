<?php

namespace App\Modules\ClinicArticle\Services;

use App\Modules\ClinicArticle\Contracts\ClinicArticleRepositoryInterface;
use App\Modules\ClinicArticle\Models\ClinicArticle;

class ClinicArticleService
{
    public function __construct(
        protected ClinicArticleRepositoryInterface $repository
    ) {}

    public function getByClinicId(int $clinicId)
    {
        return $this->repository->getByClinicId($clinicId);
    }

    public function show(int $id): ?ClinicArticle
    {
        return $this->repository->find($id);
    }

    public function createOrUpdate(int $clinicId, array $data): ClinicArticle
    {
        if (isset($data['id'])) {
            $article = $this->repository->find($data['id']);
            if (!$article || $article->clinic_id != $clinicId) {
                throw new \Exception("Article not found or unauthorized");
            }
            return $this->repository->update($article, $data);
        }

        return $this->repository->create(array_merge($data, ['clinic_id' => $clinicId]));
    }

    public function destroy(ClinicArticle $article): bool
    {
        return $this->repository->delete($article);
    }
}
