<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HabitBladeController;
use App\Http\Controllers\HabitCategoryBladeController;
use App\Http\Controllers\HabitLogBladeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuideController;

// 🔥 LOGIN & REGISTER (user BELUM login)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// 🔥 LOGOUT (user SUDAH login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔥 Semua halaman HARUS login
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Habit Logs
    Route::prefix('logs')->name('logs.')->group(function () {
        Route::get('/', [HabitLogBladeController::class, 'index'])->name('index');
        Route::get('/create', [HabitLogBladeController::class, 'create'])->name('create');
        Route::post('/', [HabitLogBladeController::class, 'store'])->name('store');
        Route::get('/{log}/edit', [HabitLogBladeController::class, 'edit'])->name('edit');
        Route::put('/{log}', [HabitLogBladeController::class, 'update'])->name('update');
        Route::delete('/{log}', [HabitLogBladeController::class, 'destroy'])->name('destroy');
    });

    // Habits
    Route::prefix('habits')->name('habits.')->group(function () {
        Route::get('/', [HabitBladeController::class, 'index'])->name('index');
        Route::get('/create', [HabitBladeController::class, 'create'])->name('create');
        Route::post('/', [HabitBladeController::class, 'store'])->name('store');
        Route::get('/{habit}/edit', [HabitBladeController::class, 'edit'])->name('edit');
        Route::put('/{habit}', [HabitBladeController::class, 'update'])->name('update');
        Route::delete('/{habit}', [HabitBladeController::class, 'destroy'])->name('destroy');
    });

    // Habit Categories
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/categories/index', [HabitCategoryBladeController::class, 'index'])->name('categories.index');
        Route::get('/create', [HabitCategoryBladeController::class, 'create'])->name('create');
        Route::post('/', [HabitCategoryBladeController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [HabitCategoryBladeController::class, 'edit'])->name('edit');
        Route::put('/{category}', [HabitCategoryBladeController::class, 'update'])->name('update');
        Route::delete('/{category}', [HabitCategoryBladeController::class, 'destroy'])->name('destroy');
    });

    // Guide
    Route::get('/guide', function () {
        return view('guide');
    })->name('guide');
});
