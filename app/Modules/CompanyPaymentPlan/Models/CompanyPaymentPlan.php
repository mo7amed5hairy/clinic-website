<?php

namespace App\Modules\CompanyPaymentPlan\Models;

use App\Models\InsuranceCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\BelongsToTenant;

class CompanyPaymentPlan extends Model
{
    use SoftDeletes, BelongsToTenant;

    protected $table = 'company_payment_plans';

    protected $fillable = [
        'tenant_id',
        'insurance_company_id',
    ];

    protected $casts = [
    ];

    public function insuranceCompany()
    {
        return $this->belongsTo(
            InsuranceCompany::class,
            'insurance_company_id'
        );
    }
}
