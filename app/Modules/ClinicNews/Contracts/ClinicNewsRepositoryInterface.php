<?php

namespace App\Modules\ClinicNews\Contracts;

use App\Modules\ClinicNews\Models\ClinicNews;

interface ClinicNewsRepositoryInterface
{
    public function getByClinicId(int $clinicId);
    public function find(int $id): ?ClinicNews;
    public function create(array $data): ClinicNews;
    public function update(ClinicNews $news, array $data): ClinicNews;
    public function delete(ClinicNews $news): bool;
}
