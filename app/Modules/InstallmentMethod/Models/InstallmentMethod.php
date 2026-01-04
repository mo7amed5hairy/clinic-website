<?php

namespace App\Modules\InstallmentMethod\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class InstallmentMethod extends Model
{
    use SoftDeletes, BelongsToTenant;

    protected $table = 'installment_methods';

    protected $fillable = [
        'tenant_id',
        'name',
        'link',
        'image',
    ];
}
