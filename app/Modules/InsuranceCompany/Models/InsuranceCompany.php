<?php

namespace App\Modules\InsuranceCompany\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;
use App\Core\Media\Traits\HasMediaUpload;

class InsuranceCompany extends Model
{
    use SoftDeletes,BelongsToTenant,HasMediaUpload;

    protected $table = 'insurance_companies';

    protected $fillable = [
        'tenant_id',
        'name',
        'link',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
