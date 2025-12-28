<?php

namespace App\Modules\CompanyPaymentPlan\Repositories;

use App\Modules\CompanyPaymentPlan\Contracts\CompanyPaymentPlanRepositoryInterface;
use App\Modules\CompanyPaymentPlan\Models\CompanyPaymentPlan;

class CompanyPaymentPlanRepository implements CompanyPaymentPlanRepositoryInterface
{
    public function list()
    {
        return CompanyPaymentPlan::where('tenant_id', tenant('id'))->get();
    }

    public function show($id): ?CompanyPaymentPlan
    {
        return CompanyPaymentPlan::where('tenant_id', tenant('id'))
            ->where('id', $id)
            ->first();
    }

    public function store(array $data): CompanyPaymentPlan
    {
        return CompanyPaymentPlan::create($data);
    }

    public function update(CompanyPaymentPlan $plan, array $data): CompanyPaymentPlan
    {
        $plan->update($data);
        return $plan;
    }

    public function destroy(CompanyPaymentPlan $plan): bool
    {
        return (bool) $plan->delete();
    }
}
