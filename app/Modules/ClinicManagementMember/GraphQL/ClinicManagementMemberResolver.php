<?php

namespace App\Modules\ClinicManagementMember\GraphQL;

use GraphQL\Error\UserError;
use App\Modules\ClinicManagementMember\Services\ClinicManagementMemberService;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class ClinicManagementMemberResolver
{
    public function __construct(
        protected ClinicManagementMemberService $service
    ) {}

    /**
     * جلب كل الأعضاء
     */
    public function list($_, array $args)
    {
        return $this->service->list();
    }

    /**
     * جلب عضو محدد
     */
    public function show($_, array $args)
    {
        $member = $this->service->show($args['id']);

        if (! $member) {
            $validator = Validator::make([], []);
            $validator->errors()->add(
                'id',
                __('ClinicManagementMember.messages.not_found')
            );

            throw new ValidationException($validator);
        }

        return $member;
    }

    /**
     * إنشاء عضو
     */
    public function create($_, array $args)
    {
        $validator = Validator::make(
            $args,
            [
                'name'      => ['required', 'string', 'min:2', 'max:255'],
                'position'  => ['nullable', 'string', 'max:255'],
                'bio'       => ['nullable', 'string'],
                'is_active' => ['nullable', 'boolean'],
                'photo'     => ['nullable'],
            ],
            [
                'name.required' => __('ClinicManagementMember.validation.name_required'),
                'name.min'      => __('ClinicManagementMember.validation.name_min'),
                'name.max'      => __('ClinicManagementMember.validation.name_max'),
                'position.max'  => __('ClinicManagementMember.validation.position_max'),
            ]
        );

        if ($validator->fails()) {
            throw new UserError(
                collect($validator->errors()->all())->join("\n")
            );
        }

        $data = $validator->validated();

        $member = $this->service->store([
            'tenant_id' => tenant('id'),
            'name'      => $data['name'],
            'position'  => $data['position'] ?? null,
            'bio'       => $data['bio'] ?? null,
            'is_active' => $data['is_active'] ?? true,
        ]);

        // رفع الصورة
        if (! empty($args['photo'])) {
            $member->uploadImage(
                $args['photo'],
                [
                    'folder' => 'clinic_members/photos',
                    'column' => 'photo',
                ]
            );
        }

        return $member;
    }

    /**
     * تحديث عضو
     */
    public function update($_, array $args)
    {
        $member = $this->service->show($args['id']);

        if (!$member) {
            $validator = Validator::make([], []);
            $validator->errors()->add(
                'id',
                __('ClinicManagementMember.messages.not_found')
            );

            throw new ValidationException($validator);
        }

        // فاليديشن للحقول الممكن تعديلها
        $validator = Validator::make(
            $args,
            [
                'name'      => ['sometimes', 'required', 'string', 'min:2', 'max:255'],
                'position'  => ['sometimes', 'nullable', 'string', 'max:255'],
                'bio'       => ['sometimes', 'nullable', 'string'],
                'is_active' => ['sometimes', 'boolean'],
                'photo'     => ['sometimes', 'nullable'], // صورة جديدة
            ],
            [
                'name.required' => __('ClinicManagementMember.validation.name_required'),
                'name.min'      => __('ClinicManagementMember.validation.name_min'),
                'name.max'      => __('ClinicManagementMember.validation.name_max'),
                'position.max'  => __('ClinicManagementMember.validation.position_max'),
            ]
        );

        if ($validator->fails()) {
            throw new UserError(
                collect($validator->errors()->all())->join("\n")
            );
        }

        $data = $validator->validated();
        $updateData = [];

        // تحديث البيانات النصية
        foreach (['name', 'position', 'bio', 'is_active'] as $field) {
            if (array_key_exists($field, $data)) {
                $updateData[$field] = $data[$field];
            }
        }

        if (!empty($updateData)) {
            $this->service->update($member, $updateData);
        }

        // تحديث الصورة مع حذف القديمة
        if (!empty($args['photo'])) {
            $member->replaceImage(
                $args['photo'],
                [
                    'folder' => 'clinic_members/photos',
                    'column' => 'photo',
                ]
            );
        }

        // إعادة تحميل الـ Model للتأكد من ظهور الصورة الجديدة
        return $member->refresh();
    }


    /**
     * حذف عضو
     */
    public function destroy($_, array $args)
    {
        $member = $this->service->show($args['id']);

        if (! $member) {
            $validator = Validator::make(
                ['id' => $args['id']],
                ['id' => ['required']],
                [
                    'id.required' => __('ClinicManagementMember.messages.not_found'),
                ]
            );

            throw new ValidationException($validator);
        }

        $this->service->destroy($member);

        return true;
    }
}
