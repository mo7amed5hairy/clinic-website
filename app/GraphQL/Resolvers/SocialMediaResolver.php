<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\SocialMedia\Services\SocialMediaService;
use Illuminate\Support\Facades\Validator;

class SocialMediaResolver
{
    public function __construct(protected SocialMediaService $service) {}

    public function show($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('SocialMedia.messages.no_clinic'));
        }
        return $this->service->getByClinicId($user->clinic_id);
    }

    public function createOrUpdate($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('SocialMedia.messages.no_clinic'));
        }

        $validator = Validator::make($args, [
            'facebook'  => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'twitter'   => ['nullable', 'string', 'max:255'],
            'youtube'   => ['nullable', 'string', 'max:255'],
            'linkedin'  => ['nullable', 'string', 'max:255'],
            'whatsapp'  => ['nullable', 'string', 'max:255'],
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
             throw new UserError(__('SocialMedia.messages.no_clinic'));
        }

        $social = $this->service->getByClinicId($user->clinic_id);
        
        if ($social) {
            $this->service->destroy($social);
        }

        return true;
    }
}
