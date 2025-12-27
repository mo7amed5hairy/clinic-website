<?php
namespace App\Modules\ClinicNews\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\Media\Traits\HasMediaUpload;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClinicNews extends Model
{
    
    use SoftDeletes, BelongsToTenant, HasMediaUpload;

    protected $table = 'clinic_news';

    protected $fillable = [
        'tenant_id',
        'title',
        'description',
        'content',
        'image',
        'is_active'
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'content' => 'array',
        'is_active' => 'boolean',
    ];
}

