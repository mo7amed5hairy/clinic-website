<?php

namespace App\GraphQL\Resolvers;

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

        if (!$member) {
            throw ValidationException::withMessages([
                'id' => [__('clinic_management_member.messages.not_found')]
            ]);
        }

        return $member;
    }


    public function create($_, array $args)
    {
        $validator = Validator::make(
            $args,
            [
                'name'      => ['required', 'string', 'min:2', 'max:255'],
                'position'  => ['nullable', 'string', 'max:255'],
                'bio'       => ['nullable', 'string'],
                'is_active' => ['boolean'],
                'photo'     => ['nullable'],
            ]
        );

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();

        // ✅ إضافة tenant_id تلقائي
        $data['tenant_id'] = tenant('id'); // tenant() دالة Stancl Tenancy بترجع التينانت الحالي

        $member = $this->service->store($data);

        if (!empty($args['photo'])) {
            $member->replaceImage($args['photo'], [
                'folder' => 'clinic_members/photos',
                'column' => 'photo',
            ]);
        }

        return $member;
    }




    public function update($_, array $args)
    {
        $member = $this->service->show($args['id']);

        if (!$member) {
            throw ValidationException::withMessages([
                'id' => [__('clinic_management_member.messages.not_found')]
            ]);
        }

        $validator = Validator::make(
            $args,
            [
                'name'      => ['sometimes', 'required', 'string', 'min:2', 'max:255'],
                'position'  => ['sometimes', 'nullable', 'string', 'max:255'],
                'bio'       => ['sometimes', 'nullable', 'string'],
                'is_active' => ['sometimes', 'boolean'],
                'photo'     => ['sometimes', 'nullable'],
            ],
            [
                'name.required' => __('clinic_management_member.validation.name_required'),
                'name.min'      => __('clinic_management_member.validation.name_min'),
                'name.max'      => __('clinic_management_member.validation.name_max'),
                'position.max'  => __('clinic_management_member.validation.position_max'),
            ]
        );

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        $updateData = [];

        foreach (['name', 'position', 'bio', 'is_active'] as $field) {
            if (array_key_exists($field, $data)) {
                $updateData[$field] = $data[$field];
            }
        }

        if (!empty($updateData)) {
            $this->service->update($member, $updateData);
        }

        if (!empty($args['photo'])) {
            $member->replaceImage($args['photo'], [
                'folder' => 'clinic_members/photos',
                'column' => 'photo',
            ]);
        }

        return $member->refresh();
    }

    public function destroy($_, array $args)
    {
        $member = $this->service->show($args['id']);

        if (!$member) {
            throw ValidationException::withMessages([
                'id' => [__('clinic_management_member.messages.not_found')]
            ]);
        }

        $this->service->destroy($member);

        return true;
    }
}

