<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\ClinicSchedule\Services\ClinicScheduleService;
use Illuminate\Support\Facades\Validator;

class ClinicScheduleResolver
{
    public function __construct(protected ClinicScheduleService $service) {}

    public function show($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('ClinicSchedule.messages.no_clinic'));
        }
        return $this->service->getByClinicId($user->clinic_id);
    }

    public function createOrUpdate($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('ClinicSchedule.messages.no_clinic'));
        }

        $validator = Validator::make($args, [
            'date_from' => ['nullable', 'date'],
            'date_to'   => ['nullable', 'date'],
            'time_from' => ['nullable'],
            'time_to'   => ['nullable'],
        ]);

        if ($validator->fails()) {
             throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        $data['tenant_id'] = tenant('id');
        
        if (isset($args['id'])) {
            $data['id'] = $args['id'];
        }

        return $this->service->createOrUpdate($user->clinic_id, $data);
    }

    public function destroy($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('ClinicSchedule.messages.no_clinic'));
        }

        $schedule = $this->service->show($args['id']);
        
        if (!$schedule || $schedule->clinic_id != $user->clinic_id) {
            throw new UserError('Not Found');
        }

        $this->service->destroy($schedule);

        return true;
    }
}
