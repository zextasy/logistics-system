<?php


use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\QuoteController;
use App\Http\Controllers\Web\ShipmentController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/track', [ShipmentController::class, 'trackForm'])->name('track.form');
Route::post('/track', [ShipmentController::class, 'track'])->name('track.show');
Route::get('/quote', [QuoteController::class, 'create'])->name('quote.create');
Route::post('/quote', [QuoteController::class, 'store'])->name('quote.store');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Shipments
    Route::prefix('shipments')->group(function () {
        Route::get('/', [ShipmentController::class, 'index'])->name('shipments.index');
        Route::get('/{shipment}', [ShipmentController::class, 'show'])->name('shipments.show');
        Route::get('/{shipment}/documents', [ShipmentController::class, 'documents'])
            ->name('shipments.documents');
        Route::get('/{shipment}/documents/{document}/download', [ShipmentController::class, 'downloadDocument'])
            ->name('shipments.documents.download');
    });

    // Quotes
    Route::prefix('quotes')->group(function () {
        Route::get('/', [QuoteController::class, 'index'])->name('quotes.index');
        Route::get('/{quote}', [QuoteController::class, 'show'])->name('quotes.show');
        Route::post('/{quote}/attachments', [QuoteController::class, 'attachments'])
            ->name('quotes.attachments');
    });

    // Profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/notifications', [ProfileController::class, 'notifications'])
            ->name('profile.notifications');
        Route::put('/notifications', [ProfileController::class, 'updateNotifications'])
            ->name('profile.notifications.update');
    });
});

// Fallback route for undefined routes
Route::fallback(function() {
    return view('errors.404');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
