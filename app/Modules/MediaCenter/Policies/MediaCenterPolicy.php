<?php

namespace App\Modules\MediaCenter\Policies;

use App\Models\User;
use App\Modules\MediaCenter\Models\MediaCenter;

class MediaCenterPolicy
{
    public function view(User $user, MediaCenter $media)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, MediaCenter $media)
    {
        return true;
    }

    public function delete(User $user, MediaCenter $media)
    {
        return true;
    }
}
