<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\ClinicStatistic\Services\ClinicStatisticService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ClinicStatisticResolver
{
    public function __construct(protected ClinicStatisticService $service) {}

    public function list($_, array $args)
    {
        return $this->service->list();
    }

    public function show($_, array $args)
    {
        $stat = $this->service->show($args['id']);

        if (!$stat) {
            throw ValidationException::withMessages([
                'id' => [__('clinic_statistic.messages.not_found')]
            ]);
        }

        return $stat;
    }

    public function create($_, array $args)
    {
        $validator = Validator::make($args, [
            'statistics_name' => ['required', 'string', 'max:255'],
            'statistic_value' => ['required', 'string', 'max:255'],
            'is_active'       => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        $data['tenant_id'] = tenant('id');

        return $this->service->store($data)->refresh();
    }

    public function update($_, array $args)
    {
        $stat = $this->service->show($args['id']);
        if (!$stat) {
            throw ValidationException::withMessages([
                'id' => [__('clinic_statistic.messages.not_found')]
            ]);
        }

        $validator = Validator::make($args, [
            'statistics_name' => ['sometimes', 'required', 'string', 'max:255'],
            'statistic_value' => ['sometimes', 'required', 'string', 'max:255'],
            'is_active'       => ['sometimes', 'boolean'],
        ]);

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();

        return $this->service->update($stat, $data)->refresh();
    }

    public function destroy($_, array $args)
    {
        $stat = $this->service->show($args['id']);
        if (!$stat) {
            throw ValidationException::withMessages([
                'id' => [__('clinic_statistic.messages.not_found')]
            ]);
        }

        $this->service->destroy($stat);
        return true;
    }
}



