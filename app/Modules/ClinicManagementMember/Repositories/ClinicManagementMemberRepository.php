<?php

namespace App\Modules\ClinicManagementMember\Repositories;

use App\Modules\ClinicManagementMember\Contracts\ClinicManagementMemberRepositoryInterface;
use App\Modules\ClinicManagementMember\Models\ClinicManagementMember;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ClinicManagementMemberRepository implements ClinicManagementMemberRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return ClinicManagementMember::query()->paginate($perPage);
    }

    public function find(int $id): ?ClinicManagementMember
    {
        return ClinicManagementMember::find($id);
    }

    public function create(array $data): ClinicManagementMember
    {
        return ClinicManagementMember::create($data);
    }

    public function update(ClinicManagementMember $member, array $data): ClinicManagementMember
    {
        $member->update($data);
        return $member;
    }

    public function delete(ClinicManagementMember $member): bool
    {
        return (bool) $member->delete();
    }
}
