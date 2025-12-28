<?php

namespace App\Modules\Unit\Services;

use App\Modules\Unit\Contracts\UnitRepositoryInterface;
use App\Modules\Unit\Models\Unit;

class UnitService
{
    public function __construct(protected UnitRepositoryInterface $repo) {}

    public function list(): array
    {
        return $this->repo->list();
    }

    public function show(int $id): ?Unit
    {
        return $this->repo->show($id);
    }

    public function store(array $data): Unit
    {
        return $this->repo->store($data);
    }

    public function update(Unit $unit, array $data): Unit
    {
        return $this->repo->update($unit, $data);
    }

    public function destroy(Unit $unit): bool
    {
        return $this->repo->destroy($unit);
    }
}
