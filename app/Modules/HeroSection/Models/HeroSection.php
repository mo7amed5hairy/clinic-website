<?php

namespace App\Modules\HeroSection\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;
use App\Core\Media\Traits\HasMediaUpload;

class HeroSection extends Model
{
    use SoftDeletes,HasMediaUpload,BelongsToTenant;

    protected $table = 'hero_sections';

    protected $fillable = [
        'tenant_id',
        'clinic_id',
        'title',
        'sub_title',
        'content',
        'image',
    ];
}
