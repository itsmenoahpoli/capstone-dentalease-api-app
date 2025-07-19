<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;

Route::prefix('v1')->group(function() {
    Route::prefix('auth')->group(function() {
        Route::post('signin', [AuthController::class, 'signin'])->name('auth.signin');

        Route::middleware('auth:sanctum')->group(function() {
            Route::post('signout', [AuthController::class, 'signout'])->name('auth.signout');
        });
    });
});
