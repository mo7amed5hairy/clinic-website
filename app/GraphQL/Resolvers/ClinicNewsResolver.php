<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\ClinicNews\Models\ClinicNews;
use App\Modules\ClinicNews\Services\ClinicNewsService;
use Illuminate\Support\Facades\Validator;

class ClinicNewsResolver
{
    public function __construct(protected ClinicNewsService $service) {}

    public function show($_, array $args)
    {
        // Publicly accessible, automatically scoped by tenant trait
        return ClinicNews::all();
    }

    public function createOrUpdate($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        // Mutation is protected by @guard in schema
        
        $validator = Validator::make($args, [
            'title'   => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'json'],
            'image'   => ['nullable'],
        ]);

        if ($validator->fails()) {
             throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        // tenant_id is automatic
        
        if (isset($args['id'])) {
            $data['id'] = $args['id'];
        }

        $news = $this->service->createOrUpdate($user->clinic_id, $data);

        if (!empty($args['image'])) {
            $news->replaceImage($args['image'], [
                'folder' => 'clinic_news/images',
                'column' => 'image',
            ]);
        }

        return $news->refresh();
    }

    public function destroy($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('ClinicNews/messages.no_clinic'));
        }

        $news = $this->service->show((int) $args['id']);
        
        if (!$news || $news->clinic_id != $user->clinic_id) {
            throw new UserError('Not Found');
        }

        $this->service->destroy($news);

        return true;
    }
}
