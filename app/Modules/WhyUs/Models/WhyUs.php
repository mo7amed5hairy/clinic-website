<?php

namespace App\Modules\WhyUs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class WhyUs extends Model
{
    use SoftDeletes, BelongsToTenant;

    protected $table = 'why_us';

    protected $fillable = [
        'tenant_id',
        'clinic_id',
        'items', // json
    ];

    protected $casts = [
        'items' => 'array',
    ];
}
