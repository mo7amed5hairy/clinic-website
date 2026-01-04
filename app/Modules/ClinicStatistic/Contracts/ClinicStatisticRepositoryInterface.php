<?php

namespace App\Modules\ClinicStatistic\Contracts;

use App\Modules\ClinicStatistic\Models\ClinicStatistic;

interface ClinicStatisticRepositoryInterface
{
    public function findByClinicId(int $clinicId): ?ClinicStatistic;
    public function find(int $id): ?ClinicStatistic;
    public function create(array $data): ClinicStatistic;
    public function update(ClinicStatistic $stat, array $data): ClinicStatistic;
    public function delete(ClinicStatistic $stat): bool;
}
