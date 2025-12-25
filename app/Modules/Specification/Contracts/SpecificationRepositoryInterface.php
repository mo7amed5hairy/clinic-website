<?php

namespace App\Modules\Specification\Contracts;

use App\Modules\Specification\Models\Specification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SpecificationRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int $id): ?Specification;

    public function create(array $data): Specification;

    public function update(Specification $doctor, array $data): Specification;

    public function delete(Specification $doctor): bool;
}
