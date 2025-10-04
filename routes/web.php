<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware(['role_web:super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
        Route::get('dashboard', function () {
            return Inertia::render('super-admin/dashboard');
        })->name('dashboard');
    });

    Route::middleware(['role_web:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', function () {
            return Inertia::render('Admin/Dashboard');
        })->name('dashboard');
    });

    Route::middleware(['role_web:customer'])->prefix('customer')->name('customer.')->group(function () {
        Route::get('dashboard', function () {
            return Inertia::render('Customer/Dashboard');
        })->name('dashboard');
    });
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
