<?php

namespace App\GraphQL\Resolvers;

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

    // قائمة كل المواعيد
    public function list()
    {
        return $this->service->list(tenant('id'));
    }

    // عرض موعد محدد
    public function show($_, array $args)
    {
        $appointment = $this->service->show($args['id']);

        if (!$appointment) {
            throw new UserError(__('modules.appointment.not_found'));
        }

        return $appointment;
    }

    // إنشاء موعد جديد
    public function create($_, array $args)
    {
        $data = GraphQLValidator::validate(StoreAppointmentRequest::class, $args['input']);

        return $this->service->store([
            'tenant_id' => tenant('id'),
            ...$data,
        ]);
    }

    // تعديل موعد
    public function update($_, array $args)
    {
        $data = GraphQLValidator::validate(UpdateAppointmentRequest::class, $args['input']);

        return $this->service->update($args['id'], $data);
    }

    // حذف موعد
    public function delete($_, array $args)
    {
        return $this->service->delete($args['id']);
    }
}

