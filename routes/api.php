<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\{AuthController, ServicesController, AppointmentsController, PatientsController, ContentDataController, ContactUsController};

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

    Route::prefix('appointments')->group(function() {
        Route::get('/', [AppointmentsController::class, 'index'])->name('appointments.index');
        Route::get('/{id}', [AppointmentsController::class, 'show'])->name('appointments.show');
        Route::post('/', [AppointmentsController::class, 'store'])->name('appointments.store');
        Route::put('/{id}', [AppointmentsController::class, 'update'])->name('appointments.update');
        Route::delete('/{id}', [AppointmentsController::class, 'destroy'])->name('appointments.destroy');
    });

    Route::prefix('patients')->group(function() {
        Route::get('/', [PatientsController::class, 'index'])->name('patients.index');
        Route::get('/{id}', [PatientsController::class, 'show'])->name('patients.show');
        Route::post('/', [PatientsController::class, 'store'])->name('patients.store');
        Route::put('/{id}', [PatientsController::class, 'update'])->name('patients.update');
        Route::delete('/{id}', [PatientsController::class, 'destroy'])->name('patients.destroy');
    });

    Route::prefix('content')->group(function() {
        Route::get('/', [ContentDataController::class, 'index'])->name('content.index');
        Route::get('/active', [ContentDataController::class, 'active'])->name('content.active');
        Route::get('/category/{category}', [ContentDataController::class, 'showByCategory'])->name('content.showByCategory');
        Route::get('/{id}', [ContentDataController::class, 'show'])->name('content.show');
        Route::post('/', [ContentDataController::class, 'store'])->name('content.store');
        Route::put('/{id}', [ContentDataController::class, 'update'])->name('content.update');
        Route::delete('/{id}', [ContentDataController::class, 'destroy'])->name('content.destroy');
    });

    Route::prefix('contact-us')->group(function() {
        Route::get('/', [ContactUsController::class, 'index'])->name('contact-us.index');
        Route::get('/{id}', [ContactUsController::class, 'show'])->name('contact-us.show');
        Route::post('/', [ContactUsController::class, 'store'])->name('contact-us.store');
        Route::put('/{id}', [ContactUsController::class, 'update'])->name('contact-us.update');
        Route::delete('/{id}', [ContactUsController::class, 'destroy'])->name('contact-us.destroy');
    });
});
