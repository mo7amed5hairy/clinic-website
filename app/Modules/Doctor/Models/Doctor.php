<?php

namespace App\Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;
use App\Casts\JsonTranslatable;
use App\Core\Media\Traits\HasMediaUpload;

class Doctor extends Model
{
    use SoftDeletes,BelongsToTenant,HasMediaUpload;

    protected $table = 'doctors';

    protected $fillable = [
        'tenant_id',
        'doctor_data',
        'is_active',
    ];

    protected $casts = [
        'doctor_data' => JsonTranslatable::class,
        'is_active'   => 'boolean',
    ];
}




