<?php

namespace App\Models;

class Unit extends BaseModel
{
    protected $casts = [
        'name'         => 'array',
        'description'  => 'array',
        'unit_content' => 'array',
    ];
}
