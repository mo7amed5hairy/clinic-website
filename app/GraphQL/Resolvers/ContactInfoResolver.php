<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\ContactInfo\Services\ContactInfoService;
use Illuminate\Support\Facades\Validator;

class ContactInfoResolver
{
    public function __construct(protected ContactInfoService $service) {}

    public function show($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('ContactInfo.messages.no_clinic'));
        }
        return $this->service->getByClinicId($user->clinic_id);
    }

    public function createOrUpdate($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('ContactInfo.messages.no_clinic'));
        }

        $validator = Validator::make($args, [
            'address' => ['nullable', 'string', 'max:255'],
            'email'   => ['nullable', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:255'],
            'phone2'  => ['nullable', 'string', 'max:255'],
            'phone3'  => ['nullable', 'string', 'max:255'],
            'phone4'  => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
             throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        $data['tenant_id'] = tenant('id');

        return $this->service->createOrUpdate($user->clinic_id, $data);
    }

    public function destroy($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('ContactInfo.messages.no_clinic'));
        }

        $info = $this->service->getByClinicId($user->clinic_id);
        
        if ($info) {
            $this->service->destroy($info);
        }

        return true;
    }
}
