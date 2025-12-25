<?php

namespace App\Modules\Specification\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specification extends Model
{
    use SoftDeletes;

    protected $table = 'specifications';

    protected $fillable = [
        'name',
        'description',
    ];

    protected $casts = [
        // لو هتحب تحافظ على نصوص عادية، مفيش casts مطلوبة
        // 'description' => 'string',
    ];
}
