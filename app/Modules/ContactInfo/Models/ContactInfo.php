<?php

namespace App\Modules\ContactInfo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class ContactInfo extends Model
{
    use SoftDeletes, BelongsToTenant;

    protected $table = 'contact_infos';

    protected $fillable = [
        'tenant_id',
        'clinic_id',
        'address',
        'email',
        'phone',
        'phone2',
        'phone3',
        'phone4',
    ];
}
