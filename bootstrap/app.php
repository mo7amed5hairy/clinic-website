<?php

use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // // Global middleware (لكل الطلبات)
        // $middleware->append(InitializeTenancyByDomain::class);

        // // (اختياري لكن مُستحسن)
        // $middleware->append(PreventAccessFromCentralDomains::class);

          $middleware->alias([
        'auth:sanctum' => EnsureFrontendRequestsAreStateful::class,
        'set-locale' => SetLocale::class,
        
    ]);
    

    })
    ->withProviders([
    App\Providers\RepositoryServiceProvider::class,
    App\Providers\ModuleRouteServiceProvider::class,

])


->withExceptions(function (Exceptions $exceptions): void {

    $exceptions->render(function (ValidationException $e, $request) {

        // API requests فقط
        if ($request->expectsJson()) {
            return response()->json([
                'status'  => false,
                'message' => __('validation.failed'),
                'errors'  => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY); // 422
        }

    });

})

    ->create();
