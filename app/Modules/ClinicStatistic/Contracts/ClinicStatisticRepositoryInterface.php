<?php

namespace App\Modules\ClinicStatistic\Contracts;

use App\Modules\ClinicStatistic\Models\ClinicStatistic;

interface ClinicStatisticRepositoryInterface
{
    public function all();
    public function find($id): ?ClinicStatistic;
    public function create(array $data): ClinicStatistic;
    public function update(ClinicStatistic $statistic, array $data): ClinicStatistic;
    public function delete(ClinicStatistic $statistic): bool;
}
