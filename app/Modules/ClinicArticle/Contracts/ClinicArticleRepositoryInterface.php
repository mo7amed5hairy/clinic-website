<?php

namespace App\Modules\ClinicArticle\Contracts;

use App\Modules\ClinicArticle\Models\ClinicArticle;

interface ClinicArticleRepositoryInterface
{
    public function getByClinicId(int $clinicId);
    public function find(int $id): ?ClinicArticle;
    public function create(array $data): ClinicArticle;
    public function update(ClinicArticle $article, array $data): ClinicArticle;
    public function delete(ClinicArticle $article): bool;
}
