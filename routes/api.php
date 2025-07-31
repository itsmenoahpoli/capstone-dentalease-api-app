<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\{AuthController, ServicesController};

Route::prefix('v1')->group(function() {
    Route::prefix('auth')->group(function() {
        Route::post('signin', [AuthController::class, 'signin'])->name('auth.signin');

        Route::middleware('auth:sanctum')->group(function() {
            Route::post('signout', [AuthController::class, 'signout'])->name('auth.signout');
        });
    });

    Route::prefix('services')->group(function() {
        Route::get('/', [ServicesController::class, 'index'])->name('services.index');
        Route::get('/{id}', [ServicesController::class, 'show'])->name('services.show');
        Route::post('/', [ServicesController::class, 'store'])->name('services.store');
        Route::put('/{id}', [ServicesController::class, 'update'])->name('services.update');
        Route::delete('/{id}', [ServicesController::class, 'destroy'])->name('services.destroy');
    });
});
