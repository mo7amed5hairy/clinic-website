<?php

namespace App\Modules\Clinic\Repositories;

use App\Modules\Clinic\Contracts\ClinicRepositoryInterface;
use App\Modules\Clinic\Models\Clinic;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ClinicRepository implements ClinicRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Clinic::query()->paginate($perPage);
    }

    public function find(int $id): ?Clinic
    {
        return Clinic::find($id);
    }

    public function create(array $data): Clinic
    {
        return Clinic::create($data);
    }

    public function update(Clinic $clinic, array $data): Clinic
    {
        $clinic->update($data);
        return $clinic;
    }

    public function delete(Clinic $clinic): bool
    {
        return (bool) $clinic->delete();
    }
}
