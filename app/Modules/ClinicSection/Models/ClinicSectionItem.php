<?php

namespace App\Modules\ClinicSection\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicSectionItem extends Model
{
    protected $fillable = [
        'clinic_section_id',
        'title',
        'description',
        'image',
        'value',
        'order',
        'is_active',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'is_active' => 'boolean',
    ];

    public function section()
    {
        return $this->belongsTo(ClinicSection::class, 'clinic_section_id');
    }
}
