<?php

namespace App\Modules\InstallmentMethod\Services;

use App\Modules\InstallmentMethod\Contracts\InstallmentMethodRepositoryInterface;
use App\Modules\InstallmentMethod\Models\InstallmentMethod;

class InstallmentMethodService
{
    public function __construct(
        protected InstallmentMethodRepositoryInterface $repository
    ) {}

    public function all()
    {
        return $this->repository->all();
    }

    public function show(int $id): ?InstallmentMethod
    {
        return $this->repository->find($id);
    }

    public function createOrUpdate(array $data): InstallmentMethod
    {
        if (isset($data['id'])) {
            $method = $this->repository->find($data['id']);
            if (!$method) {
                throw new \Exception("Installment Method not found");
            }
            return $this->repository->update($method, $data);
        }

        return $this->repository->create($data);
    }

    public function destroy(InstallmentMethod $method): bool
    {
        return $this->repository->delete($method);
    }
}
