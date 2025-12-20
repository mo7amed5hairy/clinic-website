<?php

namespace App\Models;

class ClinicNews extends BaseModel
{
    protected $casts = [
        'title'       => 'array',
        'description' => 'array',
    ];
}
