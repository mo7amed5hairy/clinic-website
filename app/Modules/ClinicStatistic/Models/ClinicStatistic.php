<?php

namespace App\Modules\ClinicStatistic\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class ClinicStatistic extends Model
{


    use SoftDeletes, BelongsToTenant;

    protected $table = 'clinic_statistics';

    protected $fillable = [
        'tenant_id',
        'statistics_name',
        'statistic_value',
        'is_active',
    ];
}
