<?php

namespace App\Modules\ClinicSchedule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClinicSchedule extends Model
{
    use SoftDeletes;

    protected $table = 'clinic_schedules';

    protected $fillable = [
        'tenant_id',
        'date_from',
        'date_to',
        'time_from',
        'time_to',
        'is_active',
    ];

    protected $casts = [
        'date_from' => 'date',
        'date_to'   => 'date',
        'time_from' => 'datetime:H:i',
        'time_to'   => 'datetime:H:i',
        'is_active' => 'boolean',
    ];
}
