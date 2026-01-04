<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\Mission\Services\MissionService;
use Illuminate\Support\Facades\Validator;

class MissionResolver
{
    public function __construct(protected MissionService $service) {}

    public function show($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('Mission.messages.no_clinic'));
        }
        return $this->service->getByClinicId($user->clinic_id);
    }

    public function createOrUpdate($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('Mission.messages.no_clinic'));
        }

        $validator = Validator::make($args, [
            'mission' => ['required', 'string'],
            'image'   => ['nullable'],
        ]);

        if ($validator->fails()) {
             throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = [
            'tenant_id' => tenant('id'),
            'mission'   => $args['mission'],
        ];

        $mission = $this->service->createOrUpdate($user->clinic_id, $data);

        // Upload/Replace Image
        if (!empty($args['image'])) {
            $mission->replaceImage($args['image'], [
                'folder' => 'missions/images',
                'column' => 'image',
            ]);
        }

        return $mission->refresh();
    }

    public function destroy($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('Mission.messages.no_clinic'));
        }

        $mission = $this->service->getByClinicId($user->clinic_id);
        
        if ($mission) {
            $this->service->destroy($mission);
        }

        return true;
    }
}
