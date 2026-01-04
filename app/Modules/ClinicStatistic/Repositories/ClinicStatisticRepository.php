<?php

namespace App\Modules\ClinicStatistic\Repositories;

use App\Modules\ClinicStatistic\Contracts\ClinicStatisticRepositoryInterface;
use App\Modules\ClinicStatistic\Models\ClinicStatistic;

class ClinicStatisticRepository implements ClinicStatisticRepositoryInterface
{
    public function findByClinicId(int $clinicId): ?ClinicStatistic
    {
        return ClinicStatistic::where('clinic_id', $clinicId)->first();
    }

    public function find(int $id): ?ClinicStatistic
    {
        return ClinicStatistic::find($id);
    }

    public function create(array $data): ClinicStatistic
    {
        return ClinicStatistic::create($data);
    }

    public function update(ClinicStatistic $stat, array $data): ClinicStatistic
    {
        $stat->update($data);
        return $stat;
    }

    public function delete(ClinicStatistic $stat): bool
    {
        return $stat->delete();
    }
}
