<?php

namespace App\Modules\Settings\Contracts;

use App\Modules\Settings\Models\Setting;

interface SettingRepositoryInterface
{
    public function getByClinicId(int $clinicId): ?Setting;

    public function getOrCreateForClinic(int $clinicId, string $tenantId): Setting;

    public function update(Setting $setting, array $data): Setting;

    public function toggleModule(int $clinicId, string $module, bool $enabled): Setting;
}
