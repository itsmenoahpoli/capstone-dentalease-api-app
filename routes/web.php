<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SwaggerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api-docs', [SwaggerController::class, 'index'])->name('swagger.index');
Route::get('/api/docs', [SwaggerController::class, 'docs'])->name('swagger.docs');
