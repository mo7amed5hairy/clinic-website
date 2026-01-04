<?php

namespace App\Modules\Clinic\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;
use App\Core\Media\Traits\HasMediaUpload;

class Clinic extends Model
{
    use SoftDeletes, BelongsToTenant, HasMediaUpload;

    protected $table = 'clinics';

    protected $fillable = [
        'tenant_id',
        'name',
        'logo',
        'color',

    ];


}
