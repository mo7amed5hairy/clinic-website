<?php

namespace App\Modules\Department\Models;

use App\Modules\Doctor\Models\Doctor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;
class Department extends Model
{
    use SoftDeletes,BelongsToTenant;

    protected $fillable = [
        'doctor_id',
        'tenant_id',
        'name',
        'is_active',
    ];

       // العلاقة مع الدكتور
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
