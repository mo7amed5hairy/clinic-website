<?php

namespace App\Modules\InsuranceCompany\Contracts;

use App\Modules\InsuranceCompany\Models\InsuranceCompany;

interface InsuranceCompanyRepositoryInterface
{
    public function list();
    public function show($id): ?InsuranceCompany;
    public function store(array $data): InsuranceCompany;
    public function update(InsuranceCompany $company, array $data): InsuranceCompany;
    public function destroy(InsuranceCompany $company): bool;
}
