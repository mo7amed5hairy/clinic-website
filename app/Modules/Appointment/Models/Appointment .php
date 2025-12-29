<?php

namespace App\Modules\Appointment\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
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
