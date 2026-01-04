<?php

namespace App\Modules\AboutUs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class AboutUs extends Model
{
    use SoftDeletes, BelongsToTenant;

    protected $table = 'about_us';

    protected $fillable = [
        'tenant_id',
        'clinic_id',
        'title',
        'description',
    ];
}
