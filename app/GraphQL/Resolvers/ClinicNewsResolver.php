<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\ClinicNews\Services\ClinicNewsService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ClinicNewsResolver
{
    public function __construct(protected ClinicNewsService $service) {}

    // جلب كل الأخبار
    public function list($_, array $args)
    {
        return $this->service->list();
    }

    // جلب خبر محدد
    public function show($_, array $args)
    {
        $news = $this->service->show($args['id']);

        if (!$news) {
            throw ValidationException::withMessages([
                'id' => [__('clinic_news.messages.not_found')]
            ]);
        }

        return $news;
    }

    // إنشاء خبر جديد
    public function create($_, array $args)
    {
        \Illuminate\Support\Facades\Log::info('ClinicNews Create Args:', $args);
        $validator = Validator::make($args['input'], [
            'title'       => ['required', 'array'],
            'description' => ['nullable', 'array'],
            'content'     => ['nullable', 'array'],
            'is_active'   => ['nullable', 'boolean'],
            'image'       => ['nullable'],
        ]);

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        $news = $this->service->store(array_merge($data, ['tenant_id' => tenant('id')]));

        if (!empty($args['input']['image'])) {
            $news->uploadImage($args['input']['image'], [
                'folder' => 'clinic_news/images',
                'column' => 'image',
            ]);
        }

        return $news->refresh();
    }

    // تحديث خبر
    public function update($_, array $args)
    {
        $news = $this->service->show($args['id']);

        if (!$news) {
            throw ValidationException::withMessages([
                'id' => [__('clinic_news.messages.not_found')]
            ]);
        }

        $validator = Validator::make($args['input'], [
            'title'       => ['sometimes', 'required', 'array'],
            'description' => ['sometimes', 'nullable', 'array'],
            'content'     => ['sometimes', 'nullable', 'array'],
            'is_active'   => ['sometimes', 'boolean'],
            'image'       => ['sometimes', 'nullable'],
        ]);

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        $updateData = [];

        foreach (['title', 'description', 'content', 'is_active'] as $field) {
            if (array_key_exists($field, $data)) {
                $updateData[$field] = $data[$field];
            }
        }

        if (!empty($updateData)) {
            $this->service->update($news, $updateData);
        }

        if (!empty($args['input']['image'])) {
            $news->replaceImage($args['input']['image'], [
                'folder' => 'clinic_news/images',
                'column' => 'image',
            ]);
        }

        return $news->refresh();
    }

    // حذف خبر
    public function destroy($_, array $args)
    {
        $news = $this->service->show($args['id']);

        if (!$news) {
            throw ValidationException::withMessages([
                'id' => [__('clinic_news.messages.not_found')]
            ]);
        }

        $this->service->destroy($news);
        return true;
    }
}

