<?php

namespace App\Modules\InstallmentMethod\Repositories;

use App\Modules\InstallmentMethod\Contracts\InstallmentMethodRepositoryInterface;
use App\Modules\InstallmentMethod\Models\InstallmentMethod;

class InstallmentMethodRepository implements InstallmentMethodRepositoryInterface
{
    public function all()
    {
        return InstallmentMethod::all();
    }

    public function find(int $id): ?InstallmentMethod
    {
        return InstallmentMethod::find($id);
    }

    public function create(array $data): InstallmentMethod
    {
        return InstallmentMethod::create($data);
    }

    public function update(InstallmentMethod $method, array $data): InstallmentMethod
    {
        $method->update($data);
        return $method;
    }

    public function delete(InstallmentMethod $method): bool
    {
        return $method->delete();
    }
}
