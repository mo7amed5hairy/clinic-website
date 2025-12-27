<?php

namespace App\Modules\ClinicStatistic\Services;

use App\Modules\ClinicStatistic\Contracts\ClinicStatisticRepositoryInterface;
use App\Modules\ClinicStatistic\Models\ClinicStatistic;

class ClinicStatisticService
{
    public function __construct(protected ClinicStatisticRepositoryInterface $repo) {}

    public function list()
    {
        return $this->repo->all();
    }

    public function show($id): ?ClinicStatistic
    {
        return $this->repo->find($id);
    }

    public function store(array $data): ClinicStatistic
    {
        return $this->repo->create($data);
    }

    public function update(ClinicStatistic $statistic, array $data): ClinicStatistic
    {
        return $this->repo->update($statistic, $data);
    }

    public function destroy(ClinicStatistic $statistic): bool
    {
        return $this->repo->delete($statistic);
    }
}
