<?php

use Illuminate\Support\Facades\Route;
use Chernogolov\Mtm\Controllers\ResourceController;
use Chernogolov\Mtm\Controllers\BaseController;
use Chernogolov\Mtm\Controllers\UserController;

Route::get('/dashboard', [BaseController::class, 'dashboard'])->middleware(['web', 'auth', 'verified'])->name('dashboard');

Route::match(['get', 'post'], '/form/{resource}', [FormController::class, 'form'])->name('form');

Route::resource('resources', ResourceController::class)->middleware(['web', 'auth', 'verified']);
Route::get('resources/clear/{id}', [ResourceController::class, 'clear'])->name('resources.clear');

Route::middleware(['web', 'auth', 'verified'])->group(function () {
    Route::resource('user', UserController::class);
    Route::get('user/template/{id}/{template}', [UserController::class, 'template'])->name('user.template');
    Route::get('user/clone/{id}', [UserController::class, 'cloning'])->name('user.clone');
});


