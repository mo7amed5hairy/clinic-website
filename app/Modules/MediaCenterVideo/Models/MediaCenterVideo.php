<?php

namespace App\Modules\MediaCenterVideo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;
use App\Core\Media\Traits\HasVideoUpload;

class MediaCenterVideo extends Model
{
    use SoftDeletes, BelongsToTenant, HasVideoUpload;

    protected $table = 'media_center_videos';

    protected $fillable = [
        'tenant_id',
        'clinic_id',
        'title',
        'video',
    ];

    protected $casts = [];
}
