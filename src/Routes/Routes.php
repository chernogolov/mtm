<?php

use Illuminate\Support\Facades\Route;
use Chernogolov\Mtm\Controllers\ResourceController;
use Chernogolov\Mtm\Controllers\BaseController;
use Chernogolov\Mtm\Controllers\UserController;
use Chernogolov\Mtm\Controllers\OptionsController;
use Chernogolov\Mtm\Controllers\ProfileController;

Route::match(['get', 'post'], '/', [BaseController::class, 'welcome'])->name('welcome');

Route::get('/dashboard', [BaseController::class, 'dashboard'])->middleware(['web', 'auth', 'verified'])->name('dashboard');
Route::match(['get', 'post'], '/site/options', [OptionsController::class, 'index'])->middleware(['web', 'auth', 'verified'])->name('options');
Route::match(['get', 'post'], '/form/{resource}', [FormController::class, 'form'])->name('form');

Route::resource('resources', ResourceController::class)->middleware(['web', 'auth', 'verified']);

Route::get('resources/clear/{id}', [ResourceController::class, 'clear'])->name('resources.clear');

Route::middleware(['web', 'auth', 'verified'])->group(function () {
    Route::resource('user', UserController::class);
    Route::get('user/template/{id}/{template}', [UserController::class, 'template'])->name('user.template');
});

Route::middleware(['web', 'auth', 'verified'])->group(function () {
    Route::get('/myprofile', [ProfileController::class, 'edit'])->name('myprofile.edit');
    Route::patch('/myprofile', [ProfileController::class, 'update'])->name('myprofile.update');
    Route::delete('/myprofile', [ProfileController::class, 'destroy'])->name('myprofile.destroy');
});


