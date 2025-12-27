<?php

namespace App\Modules\ClinicManagementMember\Services;

use App\Modules\ClinicManagementMember\Contracts\ClinicManagementMemberRepositoryInterface;
use App\Modules\ClinicManagementMember\Models\ClinicManagementMember;

class ClinicManagementMemberService
{
    public function __construct(
        protected ClinicManagementMemberRepositoryInterface $repository
    ) {}

    public function list(int $perPage = 15)
    {
        return $this->repository->paginate($perPage);
    }

    /**
     * يرجّع Member أو null
     * بدون Exceptions
     */
    public function show(int $id): ?ClinicManagementMember
    {
        return $this->repository->find($id);
    }

    public function store(array $data): ClinicManagementMember
    {
        return $this->repository->create($data);
    }

    public function update(ClinicManagementMember $member, array $data): ClinicManagementMember
    {
        return $this->repository->update($member, $data);
    }

    public function destroy(ClinicManagementMember $member): bool
    {
        return $this->repository->delete($member);
    }
}
