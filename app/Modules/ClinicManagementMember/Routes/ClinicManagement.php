<?php

use Illuminate\Support\Facades\Route;
use App\Modules\ClinicManagementMember\Http\Controllers\ClinicManagementMemberController;

Route::prefix('clinic-management-members')
    ->middleware(['auth:sanctum', 'api', 'set-locale'])
    ->group(function () {

        Route::get('/', [ClinicManagementMemberController::class, 'index']);
        Route::post('/', [ClinicManagementMemberController::class, 'store']);
        Route::get('{clinicManagementMember}', [ClinicManagementMemberController::class, 'show']);
        Route::put('{clinicManagementMember}', [ClinicManagementMemberController::class, 'update']);
        Route::delete('{clinicManagementMember}', [ClinicManagementMemberController::class, 'destroy']);
    });
