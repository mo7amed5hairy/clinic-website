<?php

namespace App\Modules\Appointment\GraphQL;

use GraphQL\Error\UserError;
use App\Core\Helpers\GraphQLValidator;
use App\Modules\Appointment\Services\AppointmentService;
use App\Modules\Appointment\Http\Requests\StoreAppointmentRequest;
use App\Modules\Appointment\Http\Requests\UpdateAppointmentRequest;

class AppointmentResolver
{
    public function __construct(
        protected AppointmentService $service
    ) {}

    public function list()
    {
        return $this->service->list(tenant('id'));
    }

    public function show($_, array $args)
    {
        $appointment = $this->service->show($args['id']);

        if (!$appointment) {
            throw new UserError(__('modules.appointment.not_found'));
        }

        return $appointment;
    }

    public function create($_, array $args)
    {
        $data = GraphQLValidator::validate(StoreAppointmentRequest::class, $args);

        return $this->service->store([
            'tenant_id' => tenant('id'),
            ...$data,
        ]);
    }

    public function update($_, array $args)
    {
        $data = GraphQLValidator::validate(UpdateAppointmentRequest::class, $args);

        return $this->service->update($data['id'], $data);
    }

    public function delete($_, array $args)
    {
        return $this->service->delete($args['id']);
    }
}
