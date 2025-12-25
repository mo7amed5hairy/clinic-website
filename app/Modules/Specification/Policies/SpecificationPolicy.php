<?php

namespace App\Modules\Specification\Policies;

use App\Models\User;
use App\Modules\Specification\Models\Specification;

class SpecificationPolicy
{
    public function view(User $user, Specification $specification): bool
    {
        // بما انه مفيش tenant_id، السماح لكل المستخدمين
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Specification $specification): bool
    {
        return true;
    }

    public function delete(User $user, Specification $specification): bool
    {
        return true;
    }
}
