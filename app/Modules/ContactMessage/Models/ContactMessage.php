<?php

namespace App\Modules\ContactMessage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\BelongsToTenant;

class ContactMessage extends Model
{
    use SoftDeletes, BelongsToTenant;

    protected $table = 'contact_messages';

    protected $fillable = [
        'tenant_id',
        'name',
        'email',
        'phone',
        'subject',
        'message',
    ];
}
