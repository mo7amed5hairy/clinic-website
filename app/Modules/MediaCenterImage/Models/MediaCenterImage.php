<?php

namespace App\Modules\MediaCenterImage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;
use App\Core\Media\Traits\HasMediaUpload;

class MediaCenterImage extends Model
{
    use SoftDeletes, BelongsToTenant, HasMediaUpload;

    protected $table = 'media_center_images';

    protected $fillable = [
        'tenant_id',
        'clinic_id',
        'title',
        'image',
    ];

    protected $casts = [];
}
