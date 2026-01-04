<?php

namespace App\Modules\WhyUs\Contracts;

use App\Modules\WhyUs\Models\WhyUs;

interface WhyUsRepositoryInterface
{
    public function findByClinicId(int $clinicId): ?WhyUs;
    public function find(int $id): ?WhyUs;
    public function create(array $data): WhyUs;
    public function update(WhyUs $whyUs, array $data): WhyUs;
    public function delete(WhyUs $whyUs): bool;
}
