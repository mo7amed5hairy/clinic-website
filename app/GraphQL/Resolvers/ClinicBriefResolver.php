<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\ClinicBrief\Services\ClinicBriefService;
use Illuminate\Support\Facades\Validator;

class ClinicBriefResolver
{
    public function __construct(protected ClinicBriefService $service) {}

    public function show($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('ClinicBrief.messages.no_clinic'));
        }
        return $this->service->getByClinicId($user->clinic_id);
    }

    public function createOrUpdate($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('ClinicBrief.messages.no_clinic'));
        }

        $validator = Validator::make($args, [
            'brief' => ['required', 'string'],
            'image' => ['nullable'],
        ]);

        if ($validator->fails()) {
             throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = [
            'tenant_id' => tenant('id'),
            'brief'     => $args['brief'],
        ];

        $brief = $this->service->createOrUpdate($user->clinic_id, $data);

        // Upload/Replace Image
        if (!empty($args['image'])) {
            $brief->replaceImage($args['image'], [
                'folder' => 'clinic_briefs/images',
                'column' => 'image',
            ]);
        }

        return $brief->refresh();
    }

    public function destroy($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('ClinicBrief.messages.no_clinic'));
        }

        $brief = $this->service->getByClinicId($user->clinic_id);
        
        if ($brief) {
            $this->service->destroy($brief);
        }

        return true;
    }
}
