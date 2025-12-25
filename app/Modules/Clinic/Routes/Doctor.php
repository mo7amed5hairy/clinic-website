<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Doctor\Http\Controllers\DoctorController;


Route::prefix('doctors')->middleware(['auth:sanctum', 'api', 'set-locale'])->group(function () {

    Route::get('/', [DoctorController::class, 'index']);
    Route::post('/', [DoctorController::class, 'store']);
    Route::get('{doctor}', [DoctorController::class, 'show']);
    Route::put('{doctor}', [DoctorController::class, 'update']);
    Route::delete('{doctor}', [DoctorController::class, 'destroy']);
});
