<?php

namespace App\Modules\ClinicStatistic\Repositories;

use App\Modules\ClinicStatistic\Contracts\ClinicStatisticRepositoryInterface;
use App\Modules\ClinicStatistic\Models\ClinicStatistic;

class ClinicStatisticRepository implements ClinicStatisticRepositoryInterface
{
    public function all()
    {
        return ClinicStatistic::all();
    }

    public function find($id): ?ClinicStatistic
    {
        return ClinicStatistic::find($id);
    }

    public function create(array $data): ClinicStatistic
    {
        return ClinicStatistic::create($data);
    }

    public function update(ClinicStatistic $statistic, array $data): ClinicStatistic
    {
        $statistic->update($data);
        return $statistic;
    }

    public function delete(ClinicStatistic $statistic): bool
    {
        return $statistic->delete();
    }
}
