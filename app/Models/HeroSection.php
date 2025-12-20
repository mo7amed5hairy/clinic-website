<?php

namespace App\Models;

class HeroSection extends BaseModel
{
    protected $casts = [
        'main_address' => 'array',
        'sub_address'  => 'array',
        'description'  => 'array',
    ];
}
