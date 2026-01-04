<?php

namespace App\Modules\InstallmentMethod\Contracts;

use App\Modules\InstallmentMethod\Models\InstallmentMethod;

interface InstallmentMethodRepositoryInterface
{
    public function all();
    public function find(int $id): ?InstallmentMethod;
    public function create(array $data): InstallmentMethod;
    public function update(InstallmentMethod $method, array $data): InstallmentMethod;
    public function delete(InstallmentMethod $method): bool;
}
