<?php

namespace App\Modules\MediaCenter\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Core\Media\Traits\UploadMultipleImages;
use App\Core\Media\Traits\UploadMultipleVideos;

class MediaCenter extends Model
{
    use SoftDeletes, UploadMultipleImages, UploadMultipleVideos;

    protected $table = 'mediacenter';

    protected $fillable = [
        'tenant_id',
        'type',
        'path',
    ];

    protected $casts = [
    ];
}
