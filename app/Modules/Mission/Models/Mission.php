<?php

namespace App\Modules\Mission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;
use App\Core\Media\Traits\HasMediaUpload;

class Mission extends Model
{
    use SoftDeletes, BelongsToTenant, HasMediaUpload;

    protected $table = 'missions';

    protected $fillable = [
        'tenant_id',
        'clinic_id',
        'mission',
        'image',
    ];
}
