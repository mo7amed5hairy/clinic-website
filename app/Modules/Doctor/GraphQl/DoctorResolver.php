<?php

namespace App\Modules\Doctor\GraphQL;

use App\Modules\Doctor\Services\DoctorService;

class DoctorResolver
{
    public function __construct(
        protected DoctorService $service
    ) {}

    public function list($_, array $args)
    {
        return $this->service->list();
    }

    public function show($_, array $args)
    {
        return $this->service->show($args['id']);
    }

    public function create($_, array $args)
    {
        return $this->service->store([
            'tenant_id'   => tenant('id'),
            'doctor_data' => $args['doctor_data'],
            'is_active'   => $args['is_active'] ?? true,
        ]);
    }
}
