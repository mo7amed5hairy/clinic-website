<?php

namespace App\Modules\Settings\Repositories;

use App\Modules\Settings\Contracts\SettingRepositoryInterface;
use App\Modules\Settings\Models\Setting;

class SettingRepository implements SettingRepositoryInterface
{
    public function getByClinicId(int $clinicId): ?Setting
    {
        return Setting::where('clinic_id', $clinicId)->first();
    }

    public function getOrCreateForClinic(int $clinicId, string $tenantId): Setting
    {
        return Setting::firstOrCreate(
            ['clinic_id' => $clinicId],
            ['tenant_id' => $tenantId, 'clinic_id' => $clinicId]
        );
    }

    public function update(Setting $setting, array $data): Setting
    {
        $setting->update($data);
        return $setting;
    }

    public function toggleModule(int $clinicId, string $module, bool $enabled): Setting
    {
        $setting = $this->getByClinicId($clinicId);
        
        if (!$setting) {
            throw new \Exception("Settings not found for clinic ID: {$clinicId}");
        }

        $moduleKey = $module . '_enabled';
        $setting->update([$moduleKey => $enabled]);

        return $setting;
    }
}
