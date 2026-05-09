<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomBookingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('welcome'));

/*
|--------------------------------------------------------------------------
| Dashboard (role-based redirect)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    return auth()->user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : app(RoomBookingController::class)->index();

})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated Users
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Profile
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // Room booking
    Route::get('/room-view', [RoomController::class, 'view'])->name('room.view');
    Route::get('/book-form', [RoomBookingController::class, 'create'])->name('bookings.create');
    Route::post('/book-room', [RoomBookingController::class, 'store'])->name('bookings.store');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [RoomBookingController::class, 'adminDashboard'])
            ->name('dashboard');

        // USERS (CRUD)
        Route::resource('users', UserController::class);

        // ROOMS (CRUD)
        Route::resource('rooms', RoomController::class)
            ->except(['show']);

        // EQUIPMENT (CRUD)
        Route::resource('equipments', EquipmentController::class)
            ->except(['show']);

        // BOOKINGS actions
        Route::put('/bookings/{id}/approve', [RoomBookingController::class, 'approve'])
            ->name('bookings.approve');

        Route::put('/bookings/{id}/reject', [RoomBookingController::class, 'reject'])
            ->name('bookings.reject');

        Route::get('/bookings/export/pdf', [RoomBookingController::class, 'exportPdf'])
            ->name('bookings.export.pdf');
    });

require __DIR__.'/auth.php';