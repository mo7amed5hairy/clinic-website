<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\HeroSection\Models\HeroSection;
use App\Modules\HeroSection\Services\HeroSectionService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class HeroSectionResolver
{
    public function __construct(protected HeroSectionService $service) {}

    // جلب كل الهيرو سيكشن

    // جلب هيرو سيكشن العيادة
    public function show($_, array $args)
    {
        // Publicly accessible, automatically scoped by tenant trait
        return HeroSection::first();
    }

    // إنشاء أو تحديث هيرو سيكشن
    public function createOrUpdate($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('HeroSection/messages.no_clinic'));
        }

        $validator = Validator::make($args, [
            'title'     => ['required', 'string', 'max:255'],
            'sub_title' => ['nullable', 'string', 'max:255'],
            'content'   => ['nullable', 'string'],
            'image'     => ['nullable'],
        ]);

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        // tenant_id is automatic via trait

        $hero = $this->service->createOrUpdate($user->clinic_id, $data);

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
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('HeroSection/messages.no_clinic'));
        }

        $hero = $this->service->getByClinicId($user->clinic_id);
        
        if (!$hero) {
             // If not found, technically successful? Or error?
             // Usually idempotent delete return true.
             return true; 
        }

        $this->service->destroy($hero);
        return true;
    }
}

