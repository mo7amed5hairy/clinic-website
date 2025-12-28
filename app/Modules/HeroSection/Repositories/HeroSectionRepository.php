<?php

namespace App\Modules\HeroSection\Repositories;

use App\Modules\HeroSection\Contracts\HeroSectionRepositoryInterface;
use App\Modules\HeroSection\Models\HeroSection;

class HeroSectionRepository implements HeroSectionRepositoryInterface
{
    public function all()
    {
        return HeroSection::all();
    }

    public function find(int $id): ?HeroSection
    {
        return HeroSection::find($id);
    }

    public function create(array $data): HeroSection
    {
        return HeroSection::create($data);
    }

    public function update(HeroSection $heroSection, array $data): HeroSection
    {
        $heroSection->update($data);
        return $heroSection;
    }

    public function delete(HeroSection $heroSection): bool
    {
        return $heroSection->delete();
    }
}
