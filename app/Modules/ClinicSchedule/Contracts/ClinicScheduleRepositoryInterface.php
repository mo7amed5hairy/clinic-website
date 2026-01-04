<?php

namespace App\Modules\ClinicSchedule\Contracts;

use App\Modules\ClinicSchedule\Models\ClinicSchedule;

interface ClinicScheduleRepositoryInterface
{
    public function getByClinicId(int $clinicId);
    public function find(int $id): ?ClinicSchedule;
    public function create(array $data): ClinicSchedule;
    public function update(ClinicSchedule $schedule, array $data): ClinicSchedule;
    public function delete(ClinicSchedule $schedule): bool;
}
