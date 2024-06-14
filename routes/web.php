<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return 'admin.dashboard';
    })->name('admin.dashboard');

    Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});
