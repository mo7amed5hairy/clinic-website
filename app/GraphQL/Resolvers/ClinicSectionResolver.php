<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\ClinicSection\Services\ClinicSectionService;
use App\Core\Helpers\GraphQLValidator;
use App\Modules\ClinicSection\Http\Requests\ShowClinicSectionRequest;
use App\Modules\ClinicSection\Http\Requests\StoreClinicSectionRequest;
use App\Modules\ClinicSection\Http\Requests\UpdateClinicSectionRequest;

class ClinicSectionResolver
{
    public function __construct(
        protected ClinicSectionService $service
    ) {}

    public function list()
    {
        return $this->service->listByClinic(tenant('id'));
    }

    public function show($_, array $args)
    {
        // Validate the id
        $data = GraphQLValidator::validate(ShowClinicSectionRequest::class, $args);

        $section = $this->service->show($data['id']);

        if (!$section) {
            throw new UserError(__('ClinicSection/messages.not_found'));
        }

        return $section;
    }


    public function create($_, array $args)
    {
        $data = GraphQLValidator::validate(StoreClinicSectionRequest::class, $args);

        return $this->service->store([
            'clinic_id' => tenant('id'),
            ...$data,
        ]);
    }

    public function update($_, array $args)
    {
        $data = GraphQLValidator::validate(UpdateClinicSectionRequest::class, $args);

        return $this->service->update($data['id'], $data);
    }

    public function delete($_, array $args)
    {
        $id = $args['id'] ?? null;

        if (!$id) {
            throw new UserError(__('modules.clinic_section.messages.id_required'));
        }

        return $this->service->delete($id);
    }
}

