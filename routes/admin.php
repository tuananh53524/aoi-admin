<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::middleware(['auth', 'simpleAcl'])->prefix('admin')->group(function () {
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');

    Route::resource('users', UserController::class);
});
