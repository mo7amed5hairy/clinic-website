<?php

namespace App\Modules\ClinicSection\Policies;

use App\Models\User;
use App\Modules\ClinicSection\Models\ClinicSection;

class ClinicSectionPolicy
{
    public function view(User $user, ClinicSection $section)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, ClinicSection $section)
    {
        return true;
    }

    public function delete(User $user, ClinicSection $section)
    {
        return true;
    }
}
