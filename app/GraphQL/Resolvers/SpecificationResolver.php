<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\Specification\Models\Specification;
use App\Modules\Specification\Services\SpecificationService;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class SpecificationResolver
{
    public function __construct(
        protected SpecificationService $service
    ) {}

    /**
     * جلب كل الـ Specifications
     */
    public function list($_, array $args)
    {
        return $this->service->list();
    }

    /**
     * جلب Specification محدد
     */
    public function show($_, array $args)
    {
        $specification = $this->service->show($args['id']);

        if (!$specification) {
            $validator = Validator::make([], []);
            $validator->errors()->add(
                'id',
                __('Specification/messages.not_found')
            );
            throw new ValidationException($validator);
        }

        return $specification;
    }

    /**
     * إنشاء Specification
     */
    public function create($_, array $args)
    {
        $validator = Validator::make(
            $args,
            [
                'name'        => ['required', 'string', 'min:2', 'max:200'],
                'description' => ['nullable', 'string'],
            ],
            [
                'name.required' => __('Specification/validation.name_required'),
                'name.min'      => __('Specification/validation.name_min'),
                'name.max'      => __('Specification/validation.name_max'),
            ]
        );

        if ($validator->fails()) {
            throw new UserError(
                collect($validator->errors()->all())->join("\n")
            );
        }

        $data = $validator->validated();

        return $this->service->store([
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
        ]);
    }

    /**
     * تحديث Specification
     */
    public function update($_, array $args)
    {
        $specification = $this->service->show($args['id']);

        if (!$specification) {
            $validator = Validator::make([], []);
            $validator->errors()->add(
                'id',
                __('Specification/messages.not_found')
            );
            throw new ValidationException($validator);
        }

        $validator = Validator::make(
            $args,
            [
                'name'        => ['sometimes', 'required', 'string', 'min:2', 'max:200'],
                'description' => ['nullable', 'string'],
            ],
            [
                'name.required' => __('Specification/validation.name_required'),
                'name.min'      => __('Specification/validation.name_min'),
                'name.max'      => __('Specification/validation.name_max'),
            ]
        );

        if ($validator->fails()) {
            throw new UserError(
                collect($validator->errors()->all())->join("\n")
            );
        }

        $data = $validator->validated();

        $updateData = [];

        if (array_key_exists('name', $data)) {
            $updateData['name'] = $data['name'];
        }

        if (array_key_exists('description', $data)) {
            $updateData['description'] = $data['description'];
        }

        if (!empty($updateData)) {
            $this->service->update($specification, $updateData);
        }

        return $specification;
    }

    /**
     * حذف Specification
     */
    public function destroy($_, array $args)
    {
        $specification = $this->service->show($args['id']);

        if (!$specification) {
            $validator = Validator::make(
                ['id' => $args['id']],
                ['id' => ['required']],
                [
                'id.required' => __('Specification/messages.not_found'),
                ]
            );
            throw new ValidationException($validator);
        }

        $this->service->destroy($specification);

        return true;
    }
}

