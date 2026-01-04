<?php

namespace App\Modules\Appointment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class Appointment extends Model
{
    use SoftDeletes, BelongsToTenant;

    protected $table = 'appointments';

    protected $fillable = [
        'tenant_id',
        'patient_name',
        'patient_phone',
        'patient_email',
        'doctor_name',
        'service_name',
        'appointment_date',
        'appointment_time',
        'status',
    ];
}
