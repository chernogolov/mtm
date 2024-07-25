<?php

use Illuminate\Support\Facades\Route;
use Chernogolov\Mtm\Controllers\ResourceController;
use Chernogolov\Mtm\Controllers\BaseController;

Route::get('/dashboard', [BaseController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::match(['get', 'post'], '/form/{resource}', [FormController::class, 'form'])->name('form');

Route::resource('resources', ResourceController::class)->middleware('web');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::resource('user', UserController::class);
    Route::get('user/template/{id}/{template}', [UserController::class, 'template'])->name('user.template');
    Route::get('user/clone/{id}', [UserController::class, 'cloning'])->name('user.clone');



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


