<?php

namespace App\Modules\CompanyPaymentPlan\Services;

use App\Modules\CompanyPaymentPlan\Contracts\CompanyPaymentPlanRepositoryInterface;
use App\Modules\CompanyPaymentPlan\Models\CompanyPaymentPlan;

class CompanyPaymentPlanService
{
    public function __construct(
        protected CompanyPaymentPlanRepositoryInterface $repo
    ) {}

    public function list()
    {
        return $this->repo->list();
    }

    public function show($id): ?CompanyPaymentPlan
    {
        return $this->repo->show($id);
    }

    public function store(array $data): CompanyPaymentPlan
    {
        return $this->repo->store($data);
    }

    public function update(CompanyPaymentPlan $plan, array $data): CompanyPaymentPlan
    {
        return $this->repo->update($plan, $data);
    }

    public function destroy(CompanyPaymentPlan $plan): bool
    {
        return $this->repo->destroy($plan);
    }
}
