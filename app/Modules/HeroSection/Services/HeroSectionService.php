<?php
namespace App\Modules\HeroSection\Services;

use App\Modules\HeroSection\Contracts\HeroSectionRepositoryInterface;
use App\Modules\HeroSection\Models\HeroSection;

class HeroSectionService
{
    public function __construct(
        protected HeroSectionRepositoryInterface $repository
    ) {}

    public function getByClinicId(int $clinicId): ?HeroSection
    {
        return $this->repository->findByClinicId($clinicId);
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

    public function createOrUpdate(int $clinicId, array $data): HeroSection
    {
        $hero = $this->repository->findByClinicId($clinicId);
        if ($hero) {
             return $this->update($hero, $data);
        }
        return $this->store(array_merge($data, ['clinic_id' => $clinicId]));
    }

    public function destroy(HeroSection $heroSection): bool
    {
        return $this->repository->delete($heroSection);
    }
}
