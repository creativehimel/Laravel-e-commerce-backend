<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UnitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/profiles', [ProfileController::class, 'index'])->name('admin.profiles');

    Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::resource('brands', BrandController::class);
    Route::get('/brands/status/{id}', [BrandController::class, 'changeStatus'])->name('brands.status');
    Route::resource('units', UnitController::class);
    Route::get('/units/status/{id}', [UnitController::class, 'changeStatus'])->name('units.status');
});
