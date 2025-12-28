<?php

namespace App\Modules\HeroSection\Policies;

use App\Modules\HeroSection\Models\HeroSection;
use App\Models\User;

class HeroSectionPolicy
{
    public function view(User $user, HeroSection $heroSection): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, HeroSection $heroSection): bool
    {
        return true;
    }

    public function delete(User $user, HeroSection $heroSection): bool
    {
        return true;
    }
}
