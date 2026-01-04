<?php

namespace App\Modules\ClinicArticle\Repositories;

use App\Modules\ClinicArticle\Contracts\ClinicArticleRepositoryInterface;
use App\Modules\ClinicArticle\Models\ClinicArticle;

class ClinicArticleRepository implements ClinicArticleRepositoryInterface
{
    public function getByClinicId(int $clinicId)
    {
        return ClinicArticle::where('clinic_id', $clinicId)->get();
    }

    public function find(int $id): ?ClinicArticle
    {
        return ClinicArticle::find($id);
    }

    public function create(array $data): ClinicArticle
    {
        return ClinicArticle::create($data);
    }

    public function update(ClinicArticle $article, array $data): ClinicArticle
    {
        $article->update($data);
        return $article;
    }

    public function delete(ClinicArticle $article): bool
    {
        return $article->delete();
    }
}
