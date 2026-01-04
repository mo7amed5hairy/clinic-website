<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\Department\Services\DepartmentService;
use App\Modules\Department\Models\Department;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DepartmentResolver
{
    public function __construct(
        protected DepartmentService $service
    ) {}

    public function list($_, array $args) {
        return $this->service->list();
    }

    public function show($_, array $args) {
        $department = $this->service->show($args['id']);

        if (!$department) {
            $validator = Validator::make([], []);
            $validator->errors()->add(
                'id',
                __('department.messages.not_found')
            );
            throw new ValidationException($validator);
        }

        return $department;
    }

    public function create($_, array $args) {
        $validator = Validator::make(
            $args,
            [
                'doctor_id' => ['required', 'exists:doctors,id'],
                'name'      => ['required', 'string', 'max:255'],
            ],
            [
                'doctor_id.required' => __('department.validation.doctor_id_required'),
                'doctor_id.exists'   => __('department.validation.doctor_id_exists'),
                'name.required'      => __('department.validation.name_required'),
                'name.max'           => __('department.validation.name_max'),
            ]
        );

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        $data['tenant_id'] = tenant('id');

        return $this->service->store($data);
    }

    public function update($_, array $args) {
        $department = $this->service->show($args['id']);

        if (!$department) {
            $validator = Validator::make([], []);
            $validator->errors()->add(
                'id',
                __('department.messages.not_found')
            );
            throw new ValidationException($validator);
        }

        $validator = Validator::make(
            $args,
            [
                'doctor_id' => ['sometimes', 'required', 'exists:doctors,id'],
                'name'      => ['sometimes', 'required', 'string', 'max:255'],
            ],
            [
                'doctor_id.required' => __('department.validation.doctor_id_required'),
                'doctor_id.exists'   => __('department.validation.doctor_id_exists'),
                'name.required'      => __('department.validation.name_required'),
                'name.max'           => __('department.validation.name_max'),
            ]
        );

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        return $this->service->update($department, $data);
    }

    public function destroy($_, array $args) {
        $department = $this->service->show($args['id']);

        if (!$department) {
            $validator = Validator::make(['id' => $args['id']], ['id' => ['required']], [
                'id.required' => __('department.messages.not_found'),
            ]);
            throw new ValidationException($validator);
        }

        return $this->service->destroy($department);
    }
}

