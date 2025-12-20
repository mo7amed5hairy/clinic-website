<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

abstract class BaseModel extends Model
{
    use BelongsToTenant;

    protected $guarded = [];
}
