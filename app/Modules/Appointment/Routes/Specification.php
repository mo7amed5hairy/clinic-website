<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Specification\Http\Controllers\SpecificationController;

Route::prefix('specifications')->middleware(['auth:sanctum', 'api', 'set-locale'])->group(function () {

    Route::get('/', [SpecificationController::class, 'index']);
    Route::post('/', [SpecificationController::class, 'store']);
    Route::get('{specification}', [SpecificationController::class, 'show']);
    Route::put('{specification}', [SpecificationController::class, 'update']);
    Route::delete('{specification}', [SpecificationController::class, 'destroy']);
});
