<?php

namespace App\Modules\HeroSection\GraphQL;

use GraphQL\Error\UserError;
use App\Modules\HeroSection\Services\HeroSectionService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class HeroSectionResolver
{
    public function __construct(protected HeroSectionService $service) {}

    // جلب كل الهيرو سيكشن
    public function list()
    {
        return $this->service->list();
    }

    // جلب هيرو سيكشن محدد
    public function show($_, array $args)
    {
        $hero = $this->service->show($args['id']);
        if (!$hero) {
            throw ValidationException::withMessages(['id'=>['Hero Section not found']]);
        }
        return $hero;
    }

    // إنشاء هيرو سيكشن
    public function create($_, array $args)
    {
        $validator = Validator::make($args, [
            'title'     => ['required', 'string', 'max:255'],
            'sub_title' => ['nullable', 'string', 'max:255'],
            'content'   => ['nullable', 'string'],
            'image'     => ['nullable'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        $hero = $this->service->store(array_merge($data, ['tenant_id' => tenant('id')]));

        if (!empty($args['image'])) {
            $hero->uploadImage($args['image'], [
                'folder' => 'hero_sections/images',
                'column' => 'image',
            ]);
        }

        return $hero->refresh();
    }

    // تحديث هيرو سيكشن
    public function update($_, array $args)
    {
        $hero = $this->service->show($args['id']);
        if (!$hero) {
            throw ValidationException::withMessages(['id'=>['Hero Section not found']]);
        }

        $validator = Validator::make($args, [
            'title'     => ['sometimes', 'required', 'string', 'max:255'],
            'sub_title' => ['sometimes', 'nullable', 'string', 'max:255'],
            'content'   => ['sometimes', 'nullable', 'string'],
            'image'     => ['sometimes', 'nullable'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        $updateData = [];

        foreach (['title','sub_title','content','is_active'] as $field) {
            if (array_key_exists($field, $data)) {
                $updateData[$field] = $data[$field];
            }
        }

        if (!empty($updateData)) {
            $this->service->update($hero, $updateData);
        }

        if (!empty($args['image'])) {
            $hero->replaceImage($args['image'], [
                'folder' => 'hero_sections/images',
                'column' => 'image',
            ]);
        }

        return $hero->refresh();
    }

    // حذف هيرو سيكشن
    public function destroy($_, array $args)
    {
        $hero = $this->service->show($args['id']);
        if (!$hero) {
            throw ValidationException::withMessages(['id'=>['Hero Section not found']]);
        }

        $this->service->destroy($hero);
        return true;
    }
}
