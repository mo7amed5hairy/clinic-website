<?php

namespace App\Modules\ClinicSchedule\GraphQL;

use App\Modules\ClinicSchedule\Services\ClinicScheduleService;
use GraphQL\Error\UserError;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ClinicScheduleResolver
{
    public function __construct(protected ClinicScheduleService $service) {}

    // جلب كل الاسكديولز
    public function list($_, array $args) {
        return $this->service->list();
    }

    // جلب اسكديول واحد
    public function show($_, array $args) {
        $schedule = $this->service->show($args['id']);
        if (!$schedule) {
            throw ValidationException::withMessages([
                'id' => [__('clinic_schedule.messages.not_found')]
            ]);
        }
        return $schedule;
    }

    // إنشاء اسكديول جديد
    public function create($_, array $args) {
        $validator = Validator::make($args, [
            'date_from' => ['required', 'date'],
            'date_to'   => ['required', 'date'],
            'time_from' => ['required', 'date_format:H:i'],
            'time_to'   => ['required', 'date_format:H:i'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        $schedule = $this->service->store(array_merge($data, ['tenant_id' => tenant('id')]));

        return $schedule->refresh();
    }

    // تحديث اسكديول موجود
    public function update($_, array $args) {
        $schedule = $this->service->show($args['id']);
        if (!$schedule) {
            throw ValidationException::withMessages([
                'id' => [__('clinic_schedule.messages.not_found')]
            ]);
        }

        $validator = Validator::make($args, [
            'date_from' => ['sometimes', 'required', 'date'],
            'date_to'   => ['sometimes', 'required', 'date'],
            'time_from' => ['sometimes', 'required', 'date_format:H:i'],
            'time_to'   => ['sometimes', 'required', 'date_format:H:i'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        $this->service->update($schedule, $data);

        return $schedule->refresh();
    }

    // حذف اسكديول
    public function destroy($_, array $args) {
        $schedule = $this->service->show($args['id']);
        if (!$schedule) {
            throw ValidationException::withMessages([
                'id' => [__('clinic_schedule.messages.not_found')]
            ]);
        }

        $this->service->destroy($schedule);
        return true;
    }
}
