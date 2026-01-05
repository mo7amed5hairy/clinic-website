<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\MediaCenterImage\Services\MediaCenterImageService;
use Illuminate\Support\Facades\Validator;

class MediaCenterImageResolver
{
    public function __construct(protected MediaCenterImageService $service) {}

    public function show($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('MediaCenterImage/messages.errors.no_clinic'));
        }
        return $this->service->getByClinicId($user->clinic_id);
    }

    public function createOrUpdate($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('MediaCenterImage/messages.errors.no_clinic'));
        }

        $validator = Validator::make($args, [
            'id'    => ['nullable', 'exists:media_center_images,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable'],
        ]);

        if ($validator->fails()) {
             throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        // 🚨 Additional validation for creation
        if (empty($args['id']) && empty($args['image'])) {
            throw new UserError(__('MediaCenterImage/messages.errors.image_required'));
        }

        $data = $validator->validated();
        // tenant_id is automatic via trait
        $data['clinic_id'] = auth()->user()->clinic_id ?? 0; // Keeping clinic_id for logic if needed, but tenant_id is auto.

        $image = $this->service->createOrUpdate($user->clinic_id, $data);

        if (!empty($args['image'])) {
            $image->replaceImage($args['image'], [
                'folder' => 'media_center/images',
                'column' => 'image',
            ]);
        }

        return $image->refresh();
    }

    public function destroy($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('MediaCenterImage/messages.errors.no_clinic'));
        }

        $image = $this->service->find($args['id']);
        
        if (!$image || $image->clinic_id != $user->clinic_id) {
            throw new UserError(__('MediaCenterImage/messages.errors.not_found'));
        }

        $this->service->destroy($image);

        return true;
    }
}
