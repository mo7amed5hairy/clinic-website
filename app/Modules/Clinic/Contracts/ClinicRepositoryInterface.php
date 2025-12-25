<?php

namespace App\Modules\Clinic\Contracts;

use App\Modules\Clinic\Models\Clinic;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ClinicRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int $id): ?Clinic;

    public function create(array $data): Clinic;

    public function update(Clinic $clinic, array $data): Clinic;

    public function delete(Clinic $clinic): bool;
}
