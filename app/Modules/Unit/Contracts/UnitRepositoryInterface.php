<?php

namespace App\Modules\Unit\Contracts;

use App\Modules\Unit\Models\Unit;

interface UnitRepositoryInterface
{
    public function list(): array;
    public function show(int $id): ?Unit;
    public function store(array $data): Unit;
    public function update(Unit $unit, array $data): Unit;
    public function destroy(Unit $unit): bool;
}
