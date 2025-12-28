<?php

namespace App\Modules\CompanyPaymentPlan\Contracts;

use App\Modules\CompanyPaymentPlan\Models\CompanyPaymentPlan;

interface CompanyPaymentPlanRepositoryInterface
{
    public function list();
    public function show($id): ?CompanyPaymentPlan;
    public function store(array $data): CompanyPaymentPlan;
    public function update(CompanyPaymentPlan $plan, array $data): CompanyPaymentPlan;
    public function destroy(CompanyPaymentPlan $plan): bool;
}
