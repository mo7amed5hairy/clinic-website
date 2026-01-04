<?php

namespace App\Modules\ClinicSchedule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class ClinicSchedule extends Model
{
    use SoftDeletes, BelongsToTenant;

    protected $table = 'clinic_schedules';

    protected $fillable = [
        'tenant_id',
        'clinic_id',
        'date_from',
        'date_to',
        'time_from',
        'time_to',
    ];
}
