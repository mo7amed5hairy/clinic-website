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
use App\Modules\ClinicManagementMember\Contracts\ClinicManagementMemberRepositoryInterface;
use App\Modules\ClinicManagementMember\Repositories\ClinicManagementMemberRepository;
use App\Modules\ClinicNews\Contracts\ClinicNewsRepositoryInterface;
use App\Modules\ClinicNews\Repositories\ClinicNewsRepository;
use App\Modules\ClinicSchedule\Contracts\ClinicScheduleRepositoryInterface;
use App\Modules\ClinicSchedule\Repositories\ClinicScheduleRepository;
use App\Modules\ClinicStatistic\Contracts\ClinicStatisticRepositoryInterface;
use App\Modules\ClinicStatistic\Repositories\ClinicStatisticRepository;
use App\Modules\Department\Contracts\DepartmentRepositoryInterface;
use App\Modules\Department\Repositories\DepartmentRepository;
use App\Modules\InsuranceCompany\Contracts\InsuranceCompanyRepositoryInterface;
use App\Modules\InsuranceCompany\Repositories\InsuranceCompanyRepository;

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

        $this->app->bind(
            ClinicManagementMemberRepositoryInterface::class,
            ClinicManagementMemberRepository::class
        );

        $this->app->bind(
            ClinicNewsRepositoryInterface::class,
            ClinicNewsRepository::class
        );

        $this->app->bind(
            ClinicScheduleRepositoryInterface::class,
            ClinicScheduleRepository::class
        );

        $this->app->bind(
            ClinicStatisticRepositoryInterface::class,
            ClinicStatisticRepository::class
        );
        $this->app->bind(
            DepartmentRepositoryInterface::class,
            DepartmentRepository::class
        );
        $this->app->bind(
            InsuranceCompanyRepositoryInterface::class,
            InsuranceCompanyRepository::class
        );
    }
}
