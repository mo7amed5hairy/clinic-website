<?php

namespace App\Modules\SocialMedia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class SocialMedia extends Model
{
    use SoftDeletes, BelongsToTenant;

    protected $table = 'social_media';

    protected $fillable = [
        'tenant_id',
        'clinic_id',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'linkedin',
        'whatsapp',
    ];
}
