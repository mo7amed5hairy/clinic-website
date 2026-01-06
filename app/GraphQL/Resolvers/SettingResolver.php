<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\Settings\Models\Setting;
use App\Modules\Settings\Services\SettingService;
use Illuminate\Support\Facades\Validator;

class SettingResolver
{
    public function __construct(
        protected SettingService $service
    ) {}

    /**
     * احصل على إعدادات العيادة الحالية
     */
    public function show($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        
        $setting = $this->service->getSettings($user->clinic_id);
        
        if (!$setting) {
            // إنشاء إعدادات افتراضية إذا لم تكن موجودة
            return $this->service->getOrCreateSettings($user->clinic_id, $user->tenant_id);
        }

        return $setting;
    }

    /**
     * قم بتحديث الإعدادات
     */
    public function update($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();

        $validator = Validator::make($args, [
            'doctors_enabled' => ['nullable', 'boolean'],
            'clinic_news_enabled' => ['nullable', 'boolean'],
            'units_enabled' => ['nullable', 'boolean'],
            'why_us_enabled' => ['nullable', 'boolean'],
            'media_center_videos_enabled' => ['nullable', 'boolean'],
            'clinic_statistics_enabled' => ['nullable', 'boolean'],
            'insurance_companies_enabled' => ['nullable', 'boolean'],
            'installment_methods_enabled' => ['nullable', 'boolean'],
            'contact_info_enabled' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        // تصفية البيانات التي لم تكن null
        $data = array_filter($validator->validated(), fn($value) => $value !== null);

        return $this->service->updateSettings($user->clinic_id, $data);
    }

    /**
     * فعل أو عطل وحدة معينة
     */
    public function toggleModule($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();

        $validator = Validator::make($args, [
            'module' => ['required', 'string', 'in:doctors,clinic_news,units,why_us,media_center_videos,clinic_statistics,insurance_companies,installment_methods,contact_info'],
            'enabled' => ['required', 'boolean'],
        ]);

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();

        return $this->service->toggleModule(
            $user->clinic_id,
            $data['module'],
            $data['enabled']
        );
    }
}
