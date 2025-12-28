<?php

namespace App\Modules\Unit\Repositories;

use App\Modules\Unit\Contracts\UnitRepositoryInterface;
use App\Modules\Unit\Models\Unit;

class UnitRepository implements UnitRepositoryInterface
{
    public function list(): array
    {
        return Unit::all()->toArray();
    }

    public function show(int $id): ?Unit
    {
        return Unit::find($id);
    }

    public function store(array $data): Unit
    {
        return Unit::create($data);
    }

    public function update(Unit $unit, array $data): Unit
    {
        $unit->update($data);
        return $unit;
    }

    public function destroy(Unit $unit): bool
    {
        return $unit->delete();
    }
}
