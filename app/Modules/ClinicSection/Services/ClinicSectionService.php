<?php

namespace App\Modules\ClinicSection\Services;

use App\Modules\ClinicSection\Contracts\ClinicSectionRepositoryInterface;

class ClinicSectionService
{
    public function __construct(
        protected ClinicSectionRepositoryInterface $repo
    ) {}

    public function listByClinic($clinicId)
    {
        return $this->repo->allByClinic($clinicId);
    }

    public function show(int $id)
    {
        return $this->repo->find($id);
    }

    public function store(array $data)
    {
        return $this->repo->create($data);
    }

    public function update(int $id, array $data)
    {
        $section = $this->repo->find($id);
        return $this->repo->update($section, $data);
    }

    public function delete(int $id)
    {
        $section = $this->repo->find($id);
        return $this->repo->delete($section);
    }
}
