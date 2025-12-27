<?php

namespace App\Modules\ClinicNews\Services;

use App\Modules\ClinicNews\Contracts\ClinicNewsRepositoryInterface;
use App\Modules\ClinicNews\Models\ClinicNews;

class ClinicNewsService
{
    protected ClinicNewsRepositoryInterface $repository;

    public function __construct(ClinicNewsRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    // بدل all()
    public function list()
    {
        return $this->repository->all();
    }

    // بدل find()
    public function show(int $id): ?ClinicNews
    {
        return $this->repository->find($id);
    }

    // بدل create()
    public function store(array $data): ClinicNews
    {
        return $this->repository->create($data);
    }

    // بدل update($id, $data)
    public function update(ClinicNews $news, array $data): ClinicNews
    {
        return $this->repository->update($news, $data);
    }

    // بدل delete($id)
    public function destroy(ClinicNews $news): bool
    {
        return $this->repository->delete($news);
    }
}
