<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

// Public routes
Route::get('/', [HotelController::class, 'index'])->name('home');
Route::get('/search', [HotelController::class, 'search'])->name('hotels.search');
Route::get('/hotels/{hotel}', [HotelController::class, 'show'])->name('hotels.show');

// Authentication routes (Breeze)
require __DIR__.'/auth.php';

// Admin routes
require __DIR__.'/admin.php';

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Bookings
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Reviews
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    //Payment
    Route::get('/payment/{booking}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{booking}/process', [PaymentController::class, 'process'])->name('payment.process');
});