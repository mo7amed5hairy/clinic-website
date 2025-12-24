<?php

namespace App\Modules\Doctor\Policies;

use App\Models\User;
use App\Modules\Doctor\Models\Doctor;

class DoctorPolicy
{
    public function view(User $user, Doctor $doctor): bool
    {
        return $user->tenant_id === $doctor->tenant_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Doctor $doctor): bool
    {
        return $user->tenant_id === $doctor->tenant_id;
    }

    public function delete(User $user, Doctor $doctor): bool
    {
        return $user->tenant_id === $doctor->tenant_id;
    }
}
