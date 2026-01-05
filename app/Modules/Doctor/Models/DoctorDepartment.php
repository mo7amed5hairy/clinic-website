<?php

namespace App\Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToTenant;

class DoctorDepartment extends Model
{
    use BelongsToTenant;
    protected $table = 'doctor_departments';

    protected $fillable = [
        'tenant_id',
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
