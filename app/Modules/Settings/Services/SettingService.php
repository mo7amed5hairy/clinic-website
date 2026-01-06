<?php

namespace App\Modules\Settings\Services;

use App\Modules\Settings\Repositories\SettingRepository;
use App\Modules\Settings\Models\Setting;

class SettingService
{
    public function __construct(
        protected SettingRepository $repository
    ) {}

    /**
     * احصل على إعدادات العيادة
     */
    public function getSettings(int $clinicId): ?Setting
    {
        return $this->repository->getByClinicId($clinicId);
    }

    /**
     * احصل على أو أنشئ إعدادات جديدة للعيادة
     */
    public function getOrCreateSettings(int $clinicId, string $tenantId): Setting
    {
        return $this->repository->getOrCreateForClinic($clinicId, $tenantId);
    }

    /**
     * قم بتحديث الإعدادات
     */
    public function updateSettings(int $clinicId, array $data): Setting
    {
        $user = auth()->guard('sanctum')->user();
        $setting = $this->repository->getOrCreateForClinic($clinicId, $user->tenant_id);
        return $this->repository->update($setting, $data);
    }

    /**
     * فعل أو عطل وحدة معينة
     */
    public function toggleModule(int $clinicId, string $module, bool $enabled): Setting
    {
        return $this->repository->toggleModule($clinicId, $module, $enabled);
    }

    /**
     * احصل على حالة وحدة معينة
     */
    public function isModuleEnabled(int $clinicId, string $module): bool
    {
        $setting = $this->repository->getByClinicId($clinicId);
        
        if (!$setting) {
            return true; // Default is enabled
        }

        $moduleKey = $module . '_enabled';
        return $setting->$moduleKey ?? true;
    }
}
