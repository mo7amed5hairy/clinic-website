<?php

namespace App\Models;

class InsuranceCompany extends BaseModel
{
    protected $casts = [
        'name' => 'array',
    ];
}