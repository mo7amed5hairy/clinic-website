<?php
namespace App\Modules\HeroSection\Services;

use App\Modules\HeroSection\Contracts\HeroSectionRepositoryInterface;
use App\Modules\HeroSection\Models\HeroSection;

class HeroSectionService
{
    public function __construct(
        protected HeroSectionRepositoryInterface $repository
    ) {}

    public function list()
    {
        return $this->repository->all();
    }

    public function show(int $id): ?HeroSection
    {
        return $this->repository->find($id);
    }

    public function store(array $data): HeroSection
    {
        return $this->repository->create($data);
    }

    public function update(HeroSection $heroSection, array $data): HeroSection
    {
        return $this->repository->update($heroSection, $data);
    }

    public function destroy(HeroSection $heroSection): bool
    {
        return $this->repository->delete($heroSection);
    }
}
