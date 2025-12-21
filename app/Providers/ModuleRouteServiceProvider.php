<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ModuleRouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mapModuleRoutes();
    }

    protected function mapModuleRoutes(): void
    {
        // جلب كل ملفات الراوتس داخل الموديولز
        $routeFiles = glob(app_path('Modules/*/Routes/*.php'));

        foreach ($routeFiles as $routeFile) {

            // اسم الملف بدون الامتداد
            $fileName = pathinfo($routeFile, PATHINFO_FILENAME);

            // تحويل الاسم لـ lowercase عشان يكون URL-friendly
            $prefix = strtolower($fileName);

            // عمل grouping مع prefix + middleware
            Route::prefix($prefix)
                ->middleware([
                    'api', 
                    \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class
                ])
                ->group($routeFile);
        }
    }
}
