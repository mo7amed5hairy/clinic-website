<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\ClinicArticle\Models\ClinicArticle;
use App\Modules\ClinicArticle\Services\ClinicArticleService;
use Illuminate\Support\Facades\Validator;

class ClinicArticleResolver
{
    public function __construct(protected ClinicArticleService $service) {}

    public function show($_, array $args)
    {
        // Publicly accessible, automatically scoped by tenant trait
        return ClinicArticle::all();
    }

    public function createOrUpdate($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('ClinicArticle/messages.no_clinic'));
        }

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

        $article = $this->service->createOrUpdate($user->clinic_id, $data);

        if (!empty($args['image'])) {
            $article->replaceImage($args['image'], [
                'folder' => 'clinic_articles/images',
                'column' => 'image',
            ]);
        }

        return $article->refresh();
    }

    public function destroy($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('ClinicArticle/messages.no_clinic'));
        }

        $article = $this->service->show((int) $args['id']);
        
        if (!$article || $article->clinic_id != $user->clinic_id) {
            throw new UserError('Not Found');
        }

        $this->service->destroy($article);

        return true;
    }
}
