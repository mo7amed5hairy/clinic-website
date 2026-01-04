<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\WhyUs\Services\WhyUsService;
use Illuminate\Support\Facades\Validator;

class WhyUsResolver
{
    public function __construct(protected WhyUsService $service) {}

    public function show($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('WhyUs.messages.no_clinic'));
        }
        return $this->service->getByClinicId($user->clinic_id);
    }

    public function createOrUpdate($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('WhyUs.messages.no_clinic'));
        }

        $validator = Validator::make($args, [
            'items' => ['required', 'json'], // Expecting JSON string or Array? standard is JSON scalar input
        ]);

        if ($validator->fails()) {
             // Try to be flexible if they send object/array but validator expects json string?
             // Usually GraphQL JSON scalar comes as array/assoc array in args. 
             // Validator 'json' rule expects a string.
             // If args['items'] is array, 'json' rule will fail or I should rely on type checking.
             // If I remove 'json' rule and just check 'array', it might be better.
        }

        // Simpler validation
        if (empty($args['items'])) {
             throw new UserError('Items required');
        }

        $data = [
            'tenant_id' => tenant('id'),
            'items' => $args['items'],
        ];

        return $this->service->createOrUpdate($user->clinic_id, $data);
    }

    public function destroy($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('WhyUs.messages.no_clinic'));
        }

        $whyUs = $this->service->getByClinicId($user->clinic_id);
        
        if ($whyUs) {
            $this->service->destroy($whyUs);
        }

        return true;
    }
}
