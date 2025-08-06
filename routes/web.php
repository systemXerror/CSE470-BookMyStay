<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Route (Protected)
Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware('auth')->name('dashboard');

// User Interface Routes
Route::get('/', [UserController::class, 'index'])->name('user.hotels');
Route::get('/hotels', [UserController::class, 'index'])->name('user.hotels');
Route::get('/hotels/{id}', [UserController::class, 'showHotel'])->name('user.hotel.detail');
Route::get('/hotels/{hotel}/rooms/{room}', [UserController::class, 'showRoom'])->name('user.room.detail');
Route::get('/search', [UserController::class, 'search'])->name('user.search');

// Booking Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/hotels/{hotel}/rooms/{room}/book', [BookingController::class, 'showBookingForm'])->name('user.booking.form');
    Route::post('/hotels/{hotel}/rooms/{room}/book', [BookingController::class, 'store'])->name('user.booking.store');
    Route::get('/bookings/{booking}/confirmation', [BookingController::class, 'confirmation'])->name('user.booking.confirmation');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('user.my-bookings');
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancelBooking'])->name('user.booking.cancel');
});

// Admin Routes (Protected)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/hotels', [AdminController::class, 'hotels'])->name('hotels');
    Route::get('/hotels/create', [AdminController::class, 'createHotel'])->name('hotels.create');
    Route::post('/hotels', [AdminController::class, 'storeHotel'])->name('hotels.store');
    Route::get('/hotels/{id}/edit', [AdminController::class, 'editHotel'])->name('hotels.edit');
    Route::put('/hotels/{id}', [AdminController::class, 'updateHotel'])->name('hotels.update');
    Route::delete('/hotels/{id}', [AdminController::class, 'deleteHotel'])->name('hotels.delete');
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::patch('/bookings/{id}/status', [AdminController::class, 'updateBookingStatus'])->name('bookings.status');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{id}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
});
