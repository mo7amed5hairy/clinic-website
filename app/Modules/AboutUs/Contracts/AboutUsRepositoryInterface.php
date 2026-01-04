<?php

namespace App\Modules\AboutUs\Contracts;

use App\Modules\AboutUs\Models\AboutUs;

interface AboutUsRepositoryInterface
{
    public function findByClinicId(int $clinicId): ?AboutUs;
    public function find(int $id): ?AboutUs;
    public function create(array $data): AboutUs;
    public function update(AboutUs $aboutUs, array $data): AboutUs;
    public function delete(AboutUs $aboutUs): bool;
}
