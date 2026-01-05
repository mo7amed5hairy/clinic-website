<?php

namespace App\GraphQL\Resolvers;

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
     * جلب عيادة المستخدم الحالي
     */
    public function show($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        
        if (! $user || ! $user->clinic_id) {
             throw new UserError(__('Clinic/messages.not_found'));
        }

        return $this->service->show($user->clinic_id);
    }



    /**
     * تحديث عيادة
     */

    public function update($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        
        if (! $user || ! $user->clinic_id) {
             throw new UserError(__('Clinic/messages.not_found'));
        }

        $clinic = $this->service->show($user->clinic_id);

        if (! $clinic) {
             throw new UserError(__('Clinic/messages.not_found'));
        }

        $validator = Validator::make(
            $args,
            [
                'name'      => ['sometimes', 'required', 'string', 'min:2', 'max:255'],
                'color'     => ['sometimes', 'nullable', 'string', 'max:255'],
                'logo'      => ['sometimes', 'nullable'],
            ],
            [
                'name.required' => __('Clinic/validation.name_required'),
                'name.min'      => __('Clinic/validation.name_min'),
                'name.max'      => __('Clinic/validation.name_max'),
                'color.max'     => __('Clinic/validation.color_max'),
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
        $user = auth()->guard('sanctum')->user();
        if (! $user || ! $user->clinic_id) {
             throw new UserError(__('Clinic/messages.not_found'));
        }

        $clinic = $this->service->show($user->clinic_id);

        if (! $clinic) {
             throw new UserError(__('Clinic/messages.not_found'));
        }

        $this->service->destroy($clinic);

        return true;
    }
}

