<?php

namespace App\Modules\ClinicNews\Repositories;

use App\Modules\ClinicNews\Contracts\ClinicNewsRepositoryInterface;
use App\Modules\ClinicNews\Models\ClinicNews;

class ClinicNewsRepository implements ClinicNewsRepositoryInterface
{
    public function getByClinicId(int $clinicId)
    {
        return ClinicNews::where('clinic_id', $clinicId)->get();
    }

    public function find(int $id): ?ClinicNews
    {
        return ClinicNews::find($id);
    }

    public function create(array $data): ClinicNews
    {
        return ClinicNews::create($data);
    }

    public function update(ClinicNews $news, array $data): ClinicNews
    {
        $news->update($data);
        return $news;
    }

    public function delete(ClinicNews $news): bool
    {
        return $news->delete();
    }
}
