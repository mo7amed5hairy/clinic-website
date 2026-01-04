<?php

namespace App\Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorDepartment extends Model
{
    protected $table = 'doctor_departments';

    protected $fillable = [
        'doctor_id',
        'clinic_id',
        'name',
        'content',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
