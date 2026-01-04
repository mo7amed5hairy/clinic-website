<?php

namespace App\Modules\ClinicArticle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;
use App\Core\Media\Traits\HasMediaUpload;

class ClinicArticle extends Model
{
    use SoftDeletes, BelongsToTenant, HasMediaUpload;

    protected $table = 'clinic_articles';

    protected $fillable = [
        'tenant_id',
        'clinic_id',
        'title',
        'content',
        'image',
    ];

    protected $casts = [
        'content' => 'array',
    ];
}
