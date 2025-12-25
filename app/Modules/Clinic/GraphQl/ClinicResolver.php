<?php

namespace App\Modules\Clinic\GraphQL;

use GraphQL\Error\UserError;
use App\Modules\Clinic\Services\ClinicService;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class ClinicResolver
{
    public function __construct(
        protected ClinicService $service
    ) {}

    /**
     * جلب كل العيادات
     */
    public function list($_, array $args)
    {
        return $this->service->list();
    }

    /**
     * جلب عيادة محددة
     */
    public function show($_, array $args)
    {
        $clinic = $this->service->show($args['id']);

        if (! $clinic) {
            $validator = Validator::make([], []);
            $validator->errors()->add(
                'id',
                __('Clinic.messages.not_found')
            );

            throw new ValidationException($validator);
        }

        return $clinic;
    }

    /**
     * إنشاء عيادة
     */
    public function create($_, array $args)
    {
        $validator = Validator::make(
            $args,
            [
                'name'      => ['required', 'string', 'min:2', 'max:255'],
                'color'     => ['nullable', 'string', 'max:255'],
                'is_active' => ['nullable', 'boolean'],
                'logo'      => ['nullable'],
            ],
            [
                'name.required' => __('Clinic.validation.name_required'),
                'name.min'      => __('Clinic.validation.name_min'),
                'name.max'      => __('Clinic.validation.name_max'),
                'color.max'     => __('Clinic.validation.color_max'),
            ]
        );

        if ($validator->fails()) {
            throw new UserError(
                collect($validator->errors()->all())->join("\n")
            );
        }

        $data = $validator->validated();

        $clinic = $this->service->store([
            'tenant_id' => tenant('id'),
            'name'      => $data['name'],
            'color'     => $data['color'] ?? null,
            'is_active' => $data['is_active'] ?? true,
        ]);

        // رفع اللوجو
        if (! empty($args['logo'])) {
            $clinic->uploadImage(
                $args['logo'],
                [
                    'folder' => 'clinics/logos',
                    'column' => 'logo',
                ]
            );
        }

        return $clinic;
    }

    /**
     * تحديث عيادة
     */

    public function update($_, array $args)
    {
        $clinic = $this->service->show($args['id']);

        if (! $clinic) {
            $validator = Validator::make([], []);
            $validator->errors()->add(
                'id',
                __('Clinic.messages.not_found')
            );

            throw new ValidationException($validator);
        }

        $validator = Validator::make(
            $args,
            [
                'name'      => ['sometimes', 'required', 'string', 'min:2', 'max:255'],
                'color'     => ['sometimes', 'nullable', 'string', 'max:255'],
                'is_active' => ['sometimes', 'boolean'],
                'logo'      => ['sometimes', 'nullable'],
            ],
            [
                'name.required' => __('Clinic.validation.name_required'),
                'name.min'      => __('Clinic.validation.name_min'),
                'name.max'      => __('Clinic.validation.name_max'),
                'color.max'     => __('Clinic.validation.color_max'),
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

        if (array_key_exists('color', $data)) {
            $updateData['color'] = $data['color'];
        }

        if (array_key_exists('is_active', $data)) {
            $updateData['is_active'] = $data['is_active'];
        }

        if (! empty($updateData)) {
            $this->service->update($clinic, $updateData);
        }

        // تحديث اللوجو مع حذف القديم
        if (! empty($args['logo'])) {
            $clinic->replaceImage(
                $args['logo'],
                [
                    'folder' => 'clinics/logos',
                    'column' => 'logo',
                ]
            );
        }

        // إعادة تحميل الـ model للتأكد من ظهور الصورة الجديدة
        return $clinic->refresh();
    }



    /**
     * حذف عيادة
     */
    public function destroy($_, array $args)
    {
        $clinic = $this->service->show($args['id']);

        if (! $clinic) {
            $validator = Validator::make(
                ['id' => $args['id']],
                ['id' => ['required']],
                [
                    'id.required' => __('Clinic.messages.not_found'),
                ]
            );

            throw new ValidationException($validator);
        }

        $this->service->destroy($clinic);

        return true;
    }
}
