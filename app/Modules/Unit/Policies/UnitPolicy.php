<?php

namespace App\Modules\Unit\Policies;

use App\Models\User;
use App\Modules\Unit\Models\Unit;

class UnitPolicy
{
    public function viewAny(User $user) { return true; }
    public function view(User $user, Unit $unit) { return true; }
    public function create(User $user) { return true; }
    public function update(User $user, Unit $unit) { return true; }
    public function delete(User $user, Unit $unit) { return true; }
}
