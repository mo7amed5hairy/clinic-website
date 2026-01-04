<?php

namespace App\Modules\ClinicSchedule\Services;

use App\Modules\ClinicSchedule\Contracts\ClinicScheduleRepositoryInterface;
use App\Modules\ClinicSchedule\Models\ClinicSchedule;

class ClinicScheduleService
{
    public function __construct(
        protected ClinicScheduleRepositoryInterface $repository
    ) {}

    public function getByClinicId(int $clinicId)
    {
        return $this->repository->getByClinicId($clinicId);
    }

    public function show(int $id): ?ClinicSchedule
    {
        return $this->repository->find($id);
    }

    public function createOrUpdate(int $clinicId, array $data): ClinicSchedule
    {
        if (isset($data['id'])) {
            $schedule = $this->repository->find($data['id']);
            if (!$schedule || $schedule->clinic_id != $clinicId) {
                throw new \Exception("Schedule not found or unauthorized");
            }
            return $this->repository->update($schedule, $data);
        }

        return $this->repository->create(array_merge($data, ['clinic_id' => $clinicId]));
    }

    public function destroy(ClinicSchedule $schedule): bool
    {
        return $this->repository->delete($schedule);
    }
}
