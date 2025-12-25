<?php

namespace App\Modules\Specification\Repositories;

use App\Modules\Specification\Contracts\SpecificationRepositoryInterface;
use App\Modules\Specification\Models\Specification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SpecificationRepository implements SpecificationRepositoryInterface
{
    /**
     * جلب Specifications مع Pagination
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Specification::query()->paginate($perPage);
    }

    /**
     * جلب Specification حسب الـ ID
     */
    public function find(int $id): ?Specification
    {
        return Specification::find($id);
    }

    /**
     * إنشاء Specification جديد
     */
    public function create(array $data): Specification
    {
        return Specification::create($data);
    }

    /**
     * تحديث Specification
     */
    public function update(Specification $specification, array $data): Specification
    {
        $specification->update($data);
        return $specification;
    }

    /**
     * حذف Specification
     */
    public function delete(Specification $specification): bool
    {
        return (bool) $specification->delete();
    }
}
