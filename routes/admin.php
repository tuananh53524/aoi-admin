<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::middleware(['auth', 'simpleAcl'])->prefix('admin')->group(function () {
    Route::resource('users', UserController::class);
});
