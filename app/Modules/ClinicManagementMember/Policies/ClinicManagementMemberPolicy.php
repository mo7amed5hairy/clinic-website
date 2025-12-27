<?php

namespace App\Modules\ClinicManagementMember\Policies;

use App\Models\User;
use App\Modules\ClinicManagementMember\Models\ClinicManagementMember;

class ClinicManagementMemberPolicy
{
    public function view(User $user, ClinicManagementMember $member): bool
    {
        return $user->tenant_id === $member->tenant_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, ClinicManagementMember $member): bool
    {
        return $user->tenant_id === $member->tenant_id;
    }

    public function delete(User $user, ClinicManagementMember $member): bool
    {
        return $user->tenant_id === $member->tenant_id;
    }
}
