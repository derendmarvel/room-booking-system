<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomBookingController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [RoomBookingController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Room Routes
    Route::get('/room-view', [RoomController::class, 'view'])
        ->name('room.view');

    // Booking Routes
    Route::get('/book-form', [RoomBookingController::class, 'create'])
        ->name('bookings.create');

    Route::post('/book-room', [RoomBookingController::class, 'store'])
        ->name('bookings.store');
});

// ADMIN ROUTES
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [RoomBookingController::class, 'adminDashboard'])
        ->name('admin.dashboard');

});

require __DIR__.'/auth.php';