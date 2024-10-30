<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;

Route::middleware(['auth', 'simpleAcl'])->prefix('admin')->group(function () {
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');

    Route::resource('users', UserController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('category', CategoryController::class);
});
