<?php

namespace App\Modules\InsuranceCompany\Services;

use App\Modules\InsuranceCompany\Contracts\InsuranceCompanyRepositoryInterface;
use App\Modules\InsuranceCompany\Models\InsuranceCompany;

class InsuranceCompanyService
{
    public function __construct(
        protected InsuranceCompanyRepositoryInterface $repo
    ) {}

    public function list()
    {
        return $this->repo->list();
    }

    public function show($id): ?InsuranceCompany
    {
        return $this->repo->show($id);
    }

    public function store(array $data): InsuranceCompany
    {
        return $this->repo->store($data);
    }

    public function update(InsuranceCompany $company, array $data): InsuranceCompany
    {
        return $this->repo->update($company, $data);
    }

    public function destroy(InsuranceCompany $company): bool
    {
        return $this->repo->destroy($company);
    }
}
