<?php

namespace App\Modules\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Setting extends Model
{
    use BelongsToTenant;

    protected $table = 'settings';

    protected $fillable = [
        'tenant_id',
        'clinic_id',
        'doctors_enabled',
        'clinic_news_enabled',
        'units_enabled',
        'why_us_enabled',
        'media_center_videos_enabled',
        'clinic_statistics_enabled',
        'insurance_companies_enabled',
        'installment_methods_enabled',
        'contact_info_enabled',
    ];

    protected $casts = [
        'doctors_enabled' => 'boolean',
        'clinic_news_enabled' => 'boolean',
        'units_enabled' => 'boolean',
        'why_us_enabled' => 'boolean',
        'media_center_videos_enabled' => 'boolean',
        'clinic_statistics_enabled' => 'boolean',
        'insurance_companies_enabled' => 'boolean',
        'installment_methods_enabled' => 'boolean',
        'contact_info_enabled' => 'boolean',
    ];
}
