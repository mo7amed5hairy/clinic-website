<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\ClinicManagementMember\Models\ClinicManagementMember;
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
        // Publicly accessible, automatically scoped by tenant trait
        return ClinicManagementMember::all();
    }

    /**
     * جلب عضو محدد بناءً على tenant_id من التوكن
     */
    public function show($_, array $args)
    {
        // الحصول على tenant_id من المستخدم المسجل
        $userTenantId = auth()->user()->tenant_id ?? null;
        
        if ($userTenantId === null) {
            throw ValidationException::withMessages([
                'tenant_id' => [__('ClinicManagementMember/messages.unauthorized')]
            ]);
        }

        // جلب العضو بناءً على tenant_id
        $member = ClinicManagementMember::where('tenant_id', $userTenantId)->first();

        if (!$member) {
            throw ValidationException::withMessages([
                'tenant_id' => [__('ClinicManagementMember/messages.not_found')]
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
                'photo'     => ['nullable'],
            ]
        );

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        // tenant_id is automatic via trait

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
        $id = isset($args['id']) ? (int) $args['id'] : 0;
        $member = $this->service->show($id);

        if (!$member) {
            throw ValidationException::withMessages([
                'id' => [__('ClinicManagementMember/messages.not_found')]
            ]);
        }

        $validator = Validator::make(
            $args,
            [
                'name'      => ['sometimes', 'required', 'string', 'min:2', 'max:255'],
                'position'  => ['sometimes', 'nullable', 'string', 'max:255'],
                'bio'       => ['sometimes', 'nullable', 'string'],
                'photo'     => ['sometimes', 'nullable'],
            ],
            [
                'name.required' => __('ClinicManagementMember/validation.name_required'),
                'name.min'      => __('ClinicManagementMember/validation.name_min'),
                'name.max'      => __('ClinicManagementMember/validation.name_max'),
                'position.max'  => __('ClinicManagementMember/validation.position_max'),
            ]
        );

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        $updateData = [];

        foreach (['name', 'position', 'bio'] as $field) {
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
        $id = isset($args['id']) ? (int) $args['id'] : 0;
        $member = $this->service->show($id);

        if (!$member) {
            throw ValidationException::withMessages([
                'id' => [__('ClinicManagementMember/messages.not_found')]
            ]);
        }

        $this->service->destroy($member);

        return true;
    }
}

