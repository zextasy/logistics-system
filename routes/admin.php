<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{AdminController,
    CountryController,
    DashboardController as AdminDashboardController,
    ShipmentController as AdminShipmentController,
    QuoteController as AdminQuoteController,
    UserController as AdminUserController};

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboards
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');//TODO check usage and modify/delete
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard.index');

    // Shipments Management
    Route::prefix('shipments')->group(function () {
        Route::get('/', [AdminShipmentController::class, 'index'])->name('shipments.index');
        Route::get('/create', [AdminShipmentController::class, 'create'])->name('shipments.create');
        Route::post('/', [AdminShipmentController::class, 'store'])->name('shipments.store');
        Route::get('/{shipment}', [AdminShipmentController::class, 'show'])->name('shipments.show');
    });

    // Quotes Management
    Route::prefix('quotes')->group(function () {
        Route::get('/', [AdminQuoteController::class, 'index'])->name('quotes.index');
        Route::get('/{quote}', [AdminQuoteController::class, 'show'])->name('quotes.show');
    });

    // Users Management
    Route::prefix('users')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [AdminUserController::class, 'create'])->name('users.create');
    });

    //Countries
    Route::prefix('countries')->group(function () {
        Route::get('/', [CountryController::class, 'index'])->name('countries.index');
        Route::get('/{country}', [CountryController::class, 'show'])->name('countries.show');
    });

});
