<?php

namespace App\GraphQL\Resolvers;

use App\Modules\Unit\Services\UnitService;
use GraphQL\Error\UserError;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UnitResolver
{
    public function __construct(protected UnitService $service) {}

    public function list($_, array $args) { return $this->service->list(); }

    public function show($_, array $args)
    {
        $unit = $this->service->show($args['id']);
        if (!$unit) {
            throw ValidationException::withMessages([
                'id' => [__('Unit/messages.not_found')]
            ]);
        }
        return $unit;
    }

    public function create($_, array $args)
    {
        $validator = Validator::make($args, [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable']
        ]);

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        // tenant_id is automatic via trait

        $unit = $this->service->store($data);

        if (!empty($args['image'])) {
            $unit->uploadImage($args['image'], [
                'folder' => 'units/images',
                'column' => 'image'
            ]);
        }

        return $unit->refresh();
    }

    public function update($_, array $args)
    {
        $unit = $this->service->show($args['id']);
        if (!$unit) {
            throw ValidationException::withMessages([
                'id' => [__('Unit/messages.not_found')]
            ]);
        }

        $validator = Validator::make($args, [
            'name'        => ['sometimes','required','string','max:255'],
            'description' => ['nullable','string'],
            'image'       => ['nullable']
        ]);

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        $updateData = array_intersect_key($data, array_flip(['name','description']));

        if (!empty($updateData)) {
            $this->service->update($unit, $updateData);
        }

        if (!empty($args['image'])) {
            $unit->replaceImage($args['image'], [
                'folder' => 'units/images',
                'column' => 'image'
            ]);
        }

        return $unit->refresh();
    }

    public function destroy($_, array $args)
    {
        $unit = $this->service->show($args['id']);
        if (!$unit) {
            throw ValidationException::withMessages([
                'id' => [__('Unit/messages.not_found')]
            ]);
        }

        $this->service->destroy($unit);
        return true;
    }
}

