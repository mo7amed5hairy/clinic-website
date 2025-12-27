<?php

namespace App\Modules\ClinicManagementMember\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;
use App\Core\Media\Traits\HasMediaUpload; 

class ClinicManagementMember extends Model
{
    use SoftDeletes, BelongsToTenant , HasMediaUpload;

    protected $table = 'clinic_management_members';

    protected $fillable = [
        'tenant_id',
        'name',
        'position',
        'bio',
        'photo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
