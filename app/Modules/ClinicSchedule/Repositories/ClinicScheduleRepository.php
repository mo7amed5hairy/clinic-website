<?php

namespace App\Modules\ClinicSchedule\Repositories;

use App\Modules\ClinicSchedule\Models\ClinicSchedule;
use App\Modules\ClinicSchedule\Contracts\ClinicScheduleRepositoryInterface;

class ClinicScheduleRepository implements ClinicScheduleRepositoryInterface
{
    public function all() {
        return ClinicSchedule::all();
    }

    public function find(int $id): ?ClinicSchedule {
        return ClinicSchedule::find($id);
    }

    public function create(array $data): ClinicSchedule {
        return ClinicSchedule::create($data);
    }

    public function update(ClinicSchedule $schedule, array $data): ClinicSchedule {
        $schedule->update($data);
        return $schedule;
    }

    public function delete(ClinicSchedule $schedule): bool {
        return $schedule->delete();
    }
}
