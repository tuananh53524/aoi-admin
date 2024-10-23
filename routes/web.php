<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
