<?php

namespace App\Modules\Specification\Services;

use App\Modules\Specification\Contracts\SpecificationRepositoryInterface;
use App\Modules\Specification\Models\Specification;

class SpecificationService
{
    public function __construct(
        protected SpecificationRepositoryInterface $repository
    ) {}

    /**
     * جلب كل الـ Specifications مع Pagination
     */
    public function list(int $perPage = 15)
    {
        return $this->repository->paginate($perPage);
    }

    /**
     * جلب Specification محدد حسب الـ ID
     * يرجع Specification أو null بدون أي Exceptions
     */
    public function show(int $id): ?Specification
    {
        return $this->repository->find($id);
    }

    /**
     * إنشاء Specification جديد
     */
    public function store(array $data): Specification
    {
        return $this->repository->create($data);
    }

    /**
     * تحديث Specification
     */
    public function update(Specification $specification, array $data): Specification
    {
        return $this->repository->update($specification, $data);
    }

    /**
     * حذف Specification
     */
    public function destroy(Specification $specification): bool
    {
        return $this->repository->delete($specification);
    }
}
