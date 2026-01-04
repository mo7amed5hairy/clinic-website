<?php

namespace App\Modules\HeroSection\Contracts;

use App\Modules\HeroSection\Models\HeroSection;

interface HeroSectionRepositoryInterface
{
    public function findByClinicId(int $clinicId): ?HeroSection;
    public function find(int $id): ?HeroSection;
    public function create(array $data): HeroSection;
    public function update(HeroSection $heroSection, array $data): HeroSection;
    public function delete(HeroSection $heroSection): bool;
}
