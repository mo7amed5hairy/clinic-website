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
use App\Modules\CompanyPaymentPlan\Contracts\CompanyPaymentPlanRepositoryInterface;
use App\Modules\CompanyPaymentPlan\Repositories\CompanyPaymentPlanRepository;
use App\Modules\ContactMessage\Contracts\ContactMessageRepositoryInterface;
use App\Modules\ContactMessage\Repositories\ContactMessageRepository;
use App\Modules\Department\Contracts\DepartmentRepositoryInterface;
use App\Modules\Department\Repositories\DepartmentRepository;
use App\Modules\HeroSection\Contracts\HeroSectionRepositoryInterface;
use App\Modules\HeroSection\Repositories\HeroSectionRepository;
use App\Modules\InsuranceCompany\Contracts\InsuranceCompanyRepositoryInterface;
use App\Modules\InsuranceCompany\Repositories\InsuranceCompanyRepository;
use App\Modules\MediaCenterImage\Contracts\MediaCenterImageRepositoryInterface;
use App\Modules\MediaCenterImage\Repositories\MediaCenterImageRepository;
use App\Modules\MediaCenterVideo\Contracts\MediaCenterVideoRepositoryInterface;
use App\Modules\MediaCenterVideo\Repositories\MediaCenterVideoRepository;
use App\Modules\Unit\Contracts\UnitRepositoryInterface;
use App\Modules\Unit\Repositories\UnitRepository;
use App\Modules\Appointment\Contracts\AppointmentRepositoryInterface;
use App\Modules\Appointment\Repositories\AppointmentRepository;
use App\Modules\AboutUs\Contracts\AboutUsRepositoryInterface;
use App\Modules\AboutUs\Repositories\AboutUsRepository;
use App\Modules\ClinicArticle\Contracts\ClinicArticleRepositoryInterface;
use App\Modules\ClinicArticle\Repositories\ClinicArticleRepository;
use App\Modules\ContactInfo\Contracts\ContactInfoRepositoryInterface;
use App\Modules\ContactInfo\Repositories\ContactInfoRepository;
use App\Modules\InstallmentMethod\Contracts\InstallmentMethodRepositoryInterface;
use App\Modules\InstallmentMethod\Repositories\InstallmentMethodRepository;
use App\Modules\Mission\Contracts\MissionRepositoryInterface;
use App\Modules\Mission\Repositories\MissionRepository;
use App\Modules\SocialMedia\Contracts\SocialMediaRepositoryInterface;
use App\Modules\SocialMedia\Repositories\SocialMediaRepository;
use App\Modules\Vision\Contracts\VisionRepositoryInterface;
use App\Modules\Vision\Repositories\VisionRepository;
use App\Modules\WhyUs\Contracts\WhyUsRepositoryInterface;
use App\Modules\WhyUs\Repositories\WhyUsRepository;

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
        $this->app->bind(
            CompanyPaymentPlanRepositoryInterface::class,
            CompanyPaymentPlanRepository::class
        );
        $this->app->bind(
            ContactMessageRepositoryInterface::class,
            ContactMessageRepository::class
        );
        $this->app->bind(
            UnitRepositoryInterface::class,
            UnitRepository::class
        );
        $this->app->bind(
            HeroSectionRepositoryInterface::class,
            HeroSectionRepository::class
        );

        $this->app->bind(
            MediaCenterImageRepositoryInterface::class,
            MediaCenterImageRepository::class
        );
        $this->app->bind(
            MediaCenterVideoRepositoryInterface::class,
            MediaCenterVideoRepository::class
        );
        $this->app->bind(
            AppointmentRepositoryInterface::class,
            AppointmentRepository::class
        );
        $this->app->bind(
            AboutUsRepositoryInterface::class,
            AboutUsRepository::class
        );
        $this->app->bind(
            ClinicArticleRepositoryInterface::class,
            ClinicArticleRepository::class
        );
        $this->app->bind(
            ContactInfoRepositoryInterface::class,
            ContactInfoRepository::class
        );
        $this->app->bind(
            InstallmentMethodRepositoryInterface::class,
            InstallmentMethodRepository::class
        );
        $this->app->bind(
            MissionRepositoryInterface::class,
            MissionRepository::class
        );
        $this->app->bind(
            SocialMediaRepositoryInterface::class,
            SocialMediaRepository::class
        );
        $this->app->bind(
            VisionRepositoryInterface::class,
            VisionRepository::class
        );
        $this->app->bind(
            WhyUsRepositoryInterface::class,
            WhyUsRepository::class
        );
    }
}
