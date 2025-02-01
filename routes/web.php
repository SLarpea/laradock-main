<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/shops', function () {
        return Inertia::render('Module/Shops');
    })->name('shops.index');

    // Route::get('/roles', function () {
    //     return Inertia::render('Module/Roles');
    // });
    Route::middleware('user_has_role')->group(function () {
        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', [\App\Http\Controllers\RoleController::class, 'index'])->name('index');
            Route::post('/create', [\App\Http\Controllers\RoleController::class, 'create'])->name('create');
            Route::post('/update', [\App\Http\Controllers\RoleController::class, 'update'])->name('update');
            Route::post('/delete', [\App\Http\Controllers\RoleController::class, 'remove'])->name('remove');
            Route::post('/change-status', [\App\Http\Controllers\RoleController::class, 'changeStatus'])->name('change-status');
        });
    });
});

Route::controller(\App\Http\Controllers\GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});

Route::get('admin-lte', function () {
    return Inertia::render('AdminLTE');
})->name('admin.lte');