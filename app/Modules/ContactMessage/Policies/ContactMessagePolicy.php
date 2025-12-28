<?php

namespace App\Modules\ContactMessage\Policies;

use App\Models\User;
use App\Modules\ContactMessage\Models\ContactMessage;

class ContactMessagePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ContactMessage $message): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, ContactMessage $message): bool
    {
        return true;
    }

    public function delete(User $user, ContactMessage $message): bool
    {
        return true;
    }
}
