<?php

namespace App\Modules\ClinicNews\Policies;

use App\Models\User;
use App\Modules\ClinicNews\Models\ClinicNews;

class ClinicNewsPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // أو حسب صلاحياتك
    }

    public function view(User $user, ClinicNews $news): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, ClinicNews $news): bool
    {
        return true;
    }

    public function delete(User $user, ClinicNews $news): bool
    {
        return true;
    }
}
