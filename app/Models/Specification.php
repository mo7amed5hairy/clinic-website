<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    protected $guarded = [];

    protected $casts = [
        'name'        => 'array',
        'description' => 'array',
    ];
}
