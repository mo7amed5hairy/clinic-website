<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Clinic\Repositories\ClinicRepository;
use App\Modules\Doctor\Repositories\DoctorRepository;
use App\Modules\User\Repositories\User\UserRepository;
use App\Modules\Clinic\Contracts\ClinicRepositoryInterface;
use App\Modules\Doctor\Contracts\DoctorRepositoryInterface;
use App\Modules\Specification\Repositories\SpecificationRepository;
use App\Modules\Specification\Contracts\SpecificationRepositoryInterface;
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

        $this->app->bind(
            SpecificationRepositoryInterface::class,
            SpecificationRepository::class
        );

        $this->app->bind(
            ClinicRepositoryInterface::class,
            ClinicRepository::class
        );
    }
}
