<?php

namespace App\Modules\ClinicStatistic\Services;

use App\Modules\ClinicStatistic\Contracts\ClinicStatisticRepositoryInterface;
use App\Modules\ClinicStatistic\Models\ClinicStatistic;

class ClinicStatisticService
{
    public function __construct(
        protected ClinicStatisticRepositoryInterface $repository
    ) {}

    public function getByClinicId(int $clinicId): ?ClinicStatistic
    {
        return $this->repository->findByClinicId($clinicId);
    }

    public function createOrUpdate(int $clinicId, array $data): ClinicStatistic
    {
        $stat = $this->repository->findByClinicId($clinicId);

        if ($stat) {
            return $this->repository->update($stat, $data);
        }

        return $this->repository->create(array_merge($data, ['clinic_id' => $clinicId]));
    }

    public function destroy(ClinicStatistic $stat): bool
    {
        return $this->repository->delete($stat);
    }
}
