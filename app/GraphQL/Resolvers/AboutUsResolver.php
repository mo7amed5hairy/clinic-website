<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\AboutUs\Services\AboutUsService;
use Illuminate\Support\Facades\Validator;

class AboutUsResolver
{
    public function __construct(protected AboutUsService $service) {}

    public function show($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('AboutUs/messages.no_clinic'));
        }
        return $this->service->getByClinicId($user->clinic_id);
    }

    public function createOrUpdate($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('AboutUs/messages.no_clinic'));
        }

        $validator = Validator::make($args, [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
             throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = [
            'tenant_id'   => tenant('id'),
            'title'       => $args['title'],
            'description' => $args['description'],
        ];

        return $this->service->createOrUpdate($user->clinic_id, $data);
    }

    public function destroy($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('AboutUs.messages.no_clinic'));
        }

        $aboutUs = $this->service->getByClinicId($user->clinic_id);
        
        if ($aboutUs) {
            $this->service->destroy($aboutUs);
        }

        return true;
    }
}
