<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Doctor\Repositories\DoctorRepository;
use App\Modules\User\Repositories\User\UserRepository;
use App\Modules\Doctor\Contracts\DoctorRepositoryInterface;
use App\Modules\User\Repositories\User\Contracts\UserRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
 public function register(): void
{
    $this->app->bind(
        UserRepositoryInterface::class,
        UserRepository::class
    );

    $this->app->bind(
        DoctorRepositoryInterface::class,
        DoctorRepository::class
    );
}

}
