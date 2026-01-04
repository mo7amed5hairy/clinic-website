<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\Vision\Services\VisionService;
use Illuminate\Support\Facades\Validator;

class VisionResolver
{
    public function __construct(protected VisionService $service) {}

    public function show($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('Vision.messages.no_clinic'));
        }
        return $this->service->getByClinicId($user->clinic_id);
    }

    public function createOrUpdate($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('Vision.messages.no_clinic'));
        }

        $validator = Validator::make($args, [
            'vision' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
             throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = [
            'tenant_id' => tenant('id'),
            'vision'    => $args['vision'],
        ];

        return $this->service->createOrUpdate($user->clinic_id, $data);
    }

    public function destroy($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('Vision.messages.no_clinic'));
        }

        $vision = $this->service->getByClinicId($user->clinic_id);
        
        if ($vision) {
            $this->service->destroy($vision);
        }

        return true;
    }
}
