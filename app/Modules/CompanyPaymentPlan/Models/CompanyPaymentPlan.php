<?php

namespace App\Modules\CompanyPaymentPlan\Models;

use App\Models\InsuranceCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyPaymentPlan extends Model
{
    use SoftDeletes;

    protected $table = 'company_payment_plans';

    protected $fillable = [
        'tenant_id',
        'insurance_company_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function insuranceCompany()
    {
        return $this->belongsTo(
            InsuranceCompany::class,
            'insurance_company_id'
        );
    }
}
