<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\User\Repositories\User\UserRepository;
use App\Modules\User\Repositories\User\Contracts\UserRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }
}
