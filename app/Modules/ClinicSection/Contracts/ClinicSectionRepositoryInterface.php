<?php

namespace App\Modules\ClinicSection\Contracts;

interface ClinicSectionRepositoryInterface
{
    public function allByClinic(int $clinicId);
    public function find(int $id);
    public function create(array $data);
    public function update($section, array $data);
    public function delete($section);
}
