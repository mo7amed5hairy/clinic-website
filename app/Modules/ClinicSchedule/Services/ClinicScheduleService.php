<?php

namespace App\Modules\ClinicSchedule\Services;

use App\Modules\ClinicSchedule\Contracts\ClinicScheduleRepositoryInterface;
use App\Modules\ClinicSchedule\Models\ClinicSchedule;

class ClinicScheduleService
{
    protected $repository;

    public function __construct(ClinicScheduleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function list()
    {
        return $this->repository->all();
    }

    public function show(int $id): ?ClinicSchedule
    {
        return $this->repository->find($id);
    }

    public function store(array $data): ClinicSchedule
    {
        return $this->repository->create($data);
    }

    public function update(ClinicSchedule $schedule, array $data): ClinicSchedule
    {
        return $this->repository->update($schedule, $data);
    }

    public function destroy(ClinicSchedule $schedule): bool
    {
        return $this->repository->delete($schedule);
    }
}
