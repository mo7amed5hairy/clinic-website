<?php

namespace App\Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Casts\JsonTranslatable;
use App\Traits\BelongsToTenant;
use App\Core\Media\Traits\HasMediaUpload;

class Doctor extends Model
{
    use SoftDeletes,BelongsToTenant,HasMediaUpload;

    protected $table = 'doctors';

    protected $fillable = [
        'tenant_id',
        'clinic_id',
        'name',
        'specialization',
        'experience',
        'image',
    ];

    public function departments()
    {
        return $this->hasMany(DoctorDepartment::class);
    }
}




