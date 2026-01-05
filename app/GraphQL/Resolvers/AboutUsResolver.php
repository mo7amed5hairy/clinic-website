<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\AboutUs\Models\AboutUs;
use App\Modules\AboutUs\Services\AboutUsService;
use Illuminate\Support\Facades\Validator;

class AboutUsResolver
{
    public function __construct(protected AboutUsService $service) {}

    public function show($_, array $args)
    {
        // Publicly accessible, automatically scoped by tenant trait
        return AboutUs::first();
    }

    public function createOrUpdate($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        // Mutation is protected by @guard in schema, so $user definitely exists.
        
        $validator = Validator::make($args, [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
             throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        // tenant_id is handled automatically by BelongsToTenant trait
        return $this->service->createOrUpdate($user->clinic_id, $validator->validated());
    }

    public function destroy($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('AboutUs/messages.no_clinic'));
        }

        $aboutUs = $this->service->getByClinicId($user->clinic_id);
        
        if ($aboutUs) {
            $this->service->destroy($aboutUs);
        }

        return true;
    }
}
