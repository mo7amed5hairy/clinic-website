<?php

namespace App\Modules\ClinicManagementMember\Contracts;

use App\Modules\ClinicManagementMember\Models\ClinicManagementMember;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ClinicManagementMemberRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int $id): ?ClinicManagementMember;

    public function create(array $data): ClinicManagementMember;

    public function update(ClinicManagementMember $member, array $data): ClinicManagementMember;

    public function delete(ClinicManagementMember $member): bool;
}
