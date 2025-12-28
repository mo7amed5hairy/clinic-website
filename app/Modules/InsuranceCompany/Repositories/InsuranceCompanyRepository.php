<?php

namespace App\Modules\InsuranceCompany\Repositories;

use App\Modules\InsuranceCompany\Contracts\InsuranceCompanyRepositoryInterface;
use App\Modules\InsuranceCompany\Models\InsuranceCompany;

class InsuranceCompanyRepository implements InsuranceCompanyRepositoryInterface
{
    public function list()
    {
        return InsuranceCompany::where('tenant_id', tenant('id'))->get();
    }

    public function show($id): ?InsuranceCompany
    {
        return InsuranceCompany::where('tenant_id', tenant('id'))->find($id);
    }

    public function store(array $data): InsuranceCompany
    {
        return InsuranceCompany::create($data);
    }

    public function update(InsuranceCompany $company, array $data): InsuranceCompany
    {
        $company->update($data);
        return $company;
    }

    public function destroy(InsuranceCompany $company): bool
    {
        return (bool) $company->delete();
    }
}
