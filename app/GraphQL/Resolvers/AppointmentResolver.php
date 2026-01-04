<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\Appointment\Services\AppointmentService;
use Illuminate\Support\Facades\Validator;

class AppointmentResolver
{
    public function __construct(protected AppointmentService $service) {}

    public function show($_, array $args)
    {
        return $this->service->all();
    }

    public function create($_, array $args)
    {
        $validator = Validator::make($args, [
            'patient_name'     => ['required', 'string', 'max:255'],
            'patient_phone'    => ['required', 'string', 'max:255'],
            'patient_email'    => ['nullable', 'email', 'max:255'],
            'doctor_name'      => ['nullable', 'string', 'max:255'],
            'service_name'     => ['required', 'string', 'max:255'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required'],
            'status'           => ['nullable', 'in:pending,completed'],
        ]);

        if ($validator->fails()) {
             throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        
        return $this->service->create($data);
    }

    public function destroy($_, array $args)
    {
        $appointment = $this->service->show($args['id']);
        
        if (!$appointment) {
            throw new UserError('Not Found');
        }

        $this->service->destroy($appointment);

        return true;
    }
}
