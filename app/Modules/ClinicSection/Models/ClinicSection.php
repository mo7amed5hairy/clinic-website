<?php

namespace App\Modules\ClinicSection\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\ClinicSection\Models\ClinicSectionItem;

class ClinicSection extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'clinic_id',
        'key',
        'title',
        'is_active',
    ];

    protected $casts = [
        'title' => 'array',
        'is_active' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(ClinicSectionItem::class);
    }
}
