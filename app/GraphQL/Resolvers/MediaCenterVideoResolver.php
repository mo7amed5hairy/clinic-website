<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\MediaCenterVideo\Services\MediaCenterVideoService;
use Illuminate\Support\Facades\Validator;

class MediaCenterVideoResolver
{
    public function __construct(protected MediaCenterVideoService $service) {}

    public function show($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('MediaCenterVideo/messages.errors.no_clinic'));
        }
        return $this->service->getByClinicId($user->clinic_id);
    }

    public function createOrUpdate($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('MediaCenterVideo/messages.errors.no_clinic'));
        }

        $validator = Validator::make($args, [
            'id'    => ['nullable', 'exists:media_center_videos,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'video' => ['nullable'],
        ]);

        if ($validator->fails()) {
             throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        // 🚨 Additional validation for creation
        if (empty($args['id']) && empty($args['video'])) {
            throw new UserError(__('MediaCenterVideo/messages.errors.video_required'));
        }

        $data = $validator->validated();
        // tenant_id is automatic
        $data['clinic_id'] = auth()->user()->clinic_id ?? 0;

        $video = $this->service->createOrUpdate($user->clinic_id, $data);

        if (!empty($args['video'])) {
            $video->replaceVideo($args['video'], [
                'folder' => 'media_center/videos',
                'column' => 'video',
            ]);
        }

        return $video->refresh();
    }

    public function destroy($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('MediaCenterVideo/messages.errors.no_clinic'));
        }

        $video = $this->service->find($args['id']);
        
        if (!$video || $video->clinic_id != $user->clinic_id) {
            throw new UserError(__('MediaCenterVideo/messages.errors.not_found'));
        }

        $this->service->destroy($video);

        return true;
    }
}
