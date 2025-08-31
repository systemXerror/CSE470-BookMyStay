<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\SpecialOfferController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\PasswordResetController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');

// Dashboard Route (Protected)
Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware('auth')->name('dashboard');

// User Interface Routes
Route::get('/', [UserController::class, 'index'])->name('user.hotels');
Route::get('/hotels', [UserController::class, 'index'])->name('user.hotels');
Route::get('/hotels/{id}', [UserController::class, 'showHotel'])->name('user.hotel.detail');
Route::get('/hotels/{hotel}/rooms/{room}', [UserController::class, 'showRoom'])->name('user.room.detail');
Route::get('/search', [UserController::class, 'search'])->name('user.search');
Route::get('/test-discount', function() {
    return view('test-discount');
})->name('test.discount');

// Booking Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/hotels/{hotel}/rooms/{room}/book', [BookingController::class, 'showBookingForm'])->name('user.booking.form');
    Route::post('/hotels/{hotel}/rooms/{room}/book', [BookingController::class, 'store'])->name('user.booking.store');
    Route::get('/bookings/{booking}/confirmation', [BookingController::class, 'confirmation'])->name('user.booking.confirmation');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('user.my-bookings');
    Route::get('/bookings', [BookingController::class, 'myBookings'])->name('user.bookings');
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancelBooking'])->name('user.booking.cancel');
    Route::post('/validate-discount-code', [BookingController::class, 'validateDiscountCode'])->name('user.validate-discount-code');
    Route::get('/test-discount/{code}', [BookingController::class, 'testDiscountCode'])->name('user.test-discount-code');
    
    // Notification Routes
    Route::get('/notifications', [BookingController::class, 'notifications'])->name('user.notifications');
    Route::patch('/notifications/{notification}/read', [BookingController::class, 'markNotificationAsRead'])->name('user.notifications.read');
    Route::patch('/notifications/read-all', [BookingController::class, 'markAllNotificationsAsRead'])->name('user.notifications.read-all');
    
    // Review Routes
    Route::get('/reviews', [ReviewController::class, 'myReviews'])->name('user.reviews');
    Route::get('/hotels/{hotel}/review', [ReviewController::class, 'createHotelReview'])->name('user.reviews.create-hotel');
    Route::post('/hotels/{hotel}/review', [ReviewController::class, 'storeHotelReview'])->name('user.reviews.store-hotel');
    Route::get('/rooms/{room}/review', [ReviewController::class, 'createRoomReview'])->name('user.reviews.create-room');
    Route::post('/rooms/{room}/review', [ReviewController::class, 'storeRoomReview'])->name('user.reviews.store-room');
    Route::get('/hotels/{hotel}/reviews', [ReviewController::class, 'hotelReviews'])->name('user.reviews.hotel');
    Route::get('/rooms/{room}/reviews', [ReviewController::class, 'roomReviews'])->name('user.reviews.room');
});

// Admin Routes (Protected)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Hotel Management
    Route::get('/hotels', [AdminController::class, 'hotels'])->name('hotels');
    Route::get('/hotels/create', [AdminController::class, 'createHotel'])->name('hotels.create');
    Route::post('/hotels', [AdminController::class, 'storeHotel'])->name('hotels.store');
    Route::get('/hotels/{id}/edit', [AdminController::class, 'editHotel'])->name('hotels.edit');
    Route::put('/hotels/{id}', [AdminController::class, 'updateHotel'])->name('hotels.update');
    Route::delete('/hotels/{id}', [AdminController::class, 'deleteHotel'])->name('hotels.delete');
    
    // Booking Management
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::patch('/bookings/{id}/status', [AdminController::class, 'updateBookingStatus'])->name('bookings.status');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}/activity', [AdminController::class, 'userActivity'])->name('users.activity');
    Route::patch('/users/{id}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    
    // Statistics and Analytics
    Route::get('/statistics', [AdminController::class, 'bookingStatistics'])->name('statistics');
    
    // Notification Management
    Route::get('/notifications', [AdminController::class, 'notifications'])->name('notifications');
    
    // Room Management
    Route::resource('rooms', RoomController::class);
    Route::patch('/rooms/{room}/toggle-availability', [RoomController::class, 'toggleAvailability'])->name('rooms.toggle-availability');
    Route::get('/hotels/{hotel}/rooms', [RoomController::class, 'hotelRooms'])->name('rooms.hotel-rooms');
    
    // Special Offers Management
    Route::resource('special-offers', SpecialOfferController::class);
    Route::patch('/special-offers/{specialOffer}/toggle-status', [SpecialOfferController::class, 'toggleStatus'])->name('special-offers.toggle-status');
    Route::get('/special-offers/generate-code', [SpecialOfferController::class, 'generateCode'])->name('special-offers.generate-code');
    
    // Review Management
    Route::resource('reviews', AdminReviewController::class);
    Route::get('/reviews/pending', [AdminReviewController::class, 'pending'])->name('reviews.pending');
    Route::get('/reviews/approved', [AdminReviewController::class, 'approved'])->name('reviews.approved');
    Route::patch('/reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::get('/hotels/{hotel}/reviews', [AdminReviewController::class, 'hotelReviews'])->name('reviews.hotel');
    Route::get('/rooms/{room}/reviews', [AdminReviewController::class, 'roomReviews'])->name('reviews.room');
    Route::post('/reviews/bulk-approve', [AdminReviewController::class, 'bulkApprove'])->name('reviews.bulk-approve');
    Route::post('/reviews/bulk-delete', [AdminReviewController::class, 'bulkDelete'])->name('reviews.bulk-delete');
});
