<?php

namespace App\Modules\ClinicStatistic\Policies;

use App\Models\User;
use App\Modules\ClinicStatistic\Models\ClinicStatistic;

class ClinicStatisticPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_clinic_statistics');
    }

    public function view(User $user, ClinicStatistic $statistic): bool
    {
        return $user->hasPermission('view_clinic_statistics');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('create_clinic_statistics');
    }

    public function update(User $user, ClinicStatistic $statistic): bool
    {
        return $user->hasPermission('update_clinic_statistics');
    }

    public function delete(User $user, ClinicStatistic $statistic): bool
    {
        return $user->hasPermission('delete_clinic_statistics');
    }
}
