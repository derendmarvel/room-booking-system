<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomBookingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\EquipmentController;
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

    // Admin Dashboard
    Route::get('/dashboard', [RoomBookingController::class, 'adminDashboard'])
        ->name('admin.dashboard');

    // Create Room Form
    Route::get('/rooms/create', [RoomController::class, 'create'])
        ->name('rooms.create');

    // Create Room
    Route::post('/rooms', [RoomController::class, 'store'])
        ->name('rooms.store');

    // Edit Room Form
    Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])
        ->name('rooms.edit');

    // Edit Room
    Route::put('/rooms/{room}', [RoomController::class, 'update'])
        ->name('rooms.update');

    // Delete Room
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])
        ->name('rooms.destroy');

    // Create Equipment form
    Route::get('/equipments/create', [EquipmentController::class, 'create'])
        ->name('equipments.create');

    // Store Equipment
    Route::post('/equipments', [EquipmentController::class, 'store'])
        ->name('equipments.store');

    // Edit Equipment
    Route::get('/equipments/{equipment}/edit', [EquipmentController::class, 'edit'])
        ->name('equipments.edit');

    // Update Equipment
    Route::put('/equipments/{equipment}', [EquipmentController::class, 'update'])
        ->name('equipments.update');

    // Delete Equipment
    Route::delete('/equipments/{equipment}', [EquipmentController::class, 'destroy'])
        ->name('equipments.destroy');

    // Booking Approval Routes
    Route::put('/bookings/{id}/approve', [RoomBookingController::class, 'approve'])
        ->name('admin.bookings.approve');

    Route::put('/bookings/{id}/reject', [RoomBookingController::class, 'reject'])
        ->name('admin.bookings.reject');

});

require __DIR__.'/auth.php';