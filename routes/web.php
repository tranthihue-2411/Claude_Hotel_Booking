<?php
// File: routes/web.php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminHotelController;
use App\Http\Controllers\Admin\AdminBookingController;
use Illuminate\Support\Facades\Route;

// ===== PUBLIC ROUTES =====
// Không cần đăng nhập

Route::get('/', [HotelController::class, 'index'])
    ->name('home');

Route::get('/search', [HotelController::class, 'search'])
    ->name('hotels.search');

Route::get('/hotels/{id}', [HotelController::class, 'show'])
    ->name('hotels.show');

// ===== AUTH ROUTES =====
// Cần đăng nhập

Route::middleware('auth')->group(function () {

    // Đặt phòng
    Route::get('/bookings/create/{roomId}', [BookingController::class, 'create'])
        ->name('bookings.create');

    Route::post('/bookings', [BookingController::class, 'store'])
        ->name('bookings.store');

    Route::get('/my-bookings', [BookingController::class, 'index'])
        ->name('bookings.index');

    Route::get('/bookings/{id}', [BookingController::class, 'show'])
        ->name('bookings.show');

    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel'])
        ->name('bookings.cancel');

    // Hồ sơ cá nhân
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// ===== ADMIN ROUTES =====
// Cần đăng nhập — prefix: admin

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard thống kê
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Quản lý khách sạn
        Route::resource('hotels', AdminHotelController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

        // Quản lý đặt phòng
        Route::get('/bookings', [AdminBookingController::class, 'index'])
            ->name('bookings.index');

        Route::get('/bookings/{id}', [AdminBookingController::class, 'show'])
            ->name('bookings.show');

        Route::patch('/bookings/{id}/status', [AdminBookingController::class, 'updateStatus'])
            ->name('bookings.updateStatus');
    });

// ===== BREEZE AUTH ROUTES =====
// Login, Register, Password Reset...

require __DIR__.'/auth.php';