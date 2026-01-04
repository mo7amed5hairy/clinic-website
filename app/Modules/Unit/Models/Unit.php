<?php

namespace App\Modules\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;
use App\Core\Media\Traits\HasMediaUpload;

class Unit extends Model
{
    use SoftDeletes,BelongsToTenant,HasMediaUpload;

    protected $table = 'units';

    protected $fillable = [
        'tenant_id',
        'name',
        'description',
        'image',
    ];
}
