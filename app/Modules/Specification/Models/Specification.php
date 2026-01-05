<?php

namespace App\Modules\Specification\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\BelongsToTenant;

class Specification extends Model
{
    use SoftDeletes, BelongsToTenant;

    protected $table = 'specifications';

    protected $fillable = [
        'tenant_id',
        'name',
        'description',
    ];

    protected $casts = [
        // لو هتحب تحافظ على نصوص عادية، مفيش casts مطلوبة
        // 'description' => 'string',
    ];
}
