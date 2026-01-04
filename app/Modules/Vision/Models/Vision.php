<?php

namespace App\Modules\Vision\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class Vision extends Model
{
    use SoftDeletes, BelongsToTenant;

    protected $table = 'visions';

    protected $fillable = [
        'tenant_id',
        'clinic_id',
        'vision',
    ];
}
