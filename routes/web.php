<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
// Tracking Routes
Route::get('/track', [TrackingController::class, 'showForm'])->name('tracking.form');
Route::post('/track', [TrackingController::class, 'track'])->name('tracking.track');
Route::get('/track/{tracking_number}', [TrackingController::class, 'show'])->name('tracking.show');

// Quote Routes
Route::get('/quote', [QuoteController::class, 'create'])->name('quote.create');
Route::post('/quote', [QuoteController::class, 'store'])->name('quote.store');

// Static Pages
Route::view('/terms', 'pages.terms')->name('terms');
Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/contact', 'pages.contact')->name('contact');
/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    // Profile Routes
    Route::view('profile', 'profile')
        ->middleware(['auth'])
        ->name('profile');

    // Documents Routes
    Route::prefix('documents')->group(function () {
        Route::get('/', [DocumentController::class, 'index'])->name('documents.index');
        Route::get('/{document}', [DocumentController::class, 'show'])->name('documents.show');
        Route::get('/{document}/download', [DocumentController::class, 'download'])
            ->name('documents.download')
            ->middleware('signed');
    });

    // Shipments Routes
    Route::prefix('shipments')->group(function () {
        Route::get('/', [ShipmentController::class, 'index'])->name('shipments.index');
        Route::get('/{shipment}', [ShipmentController::class, 'show'])->name('shipments.show');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Admin Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Shipments Management
    Route::prefix('shipments')->group(function () {
        Route::get('/', [AdminController::class, 'shipments'])->name('admin.shipments.index');
        Route::get('/{shipment}', [AdminController::class, 'showShipment'])->name('admin.shipments.show');
        Route::get('/create', [AdminController::class, 'createShipment'])->name('admin.shipments.create');
        Route::post('/', [AdminController::class, 'storeShipment'])->name('admin.shipments.store');
        Route::get('/{shipment}/edit', [AdminController::class, 'editShipment'])->name('admin.shipments.edit');
        Route::put('/{shipment}', [AdminController::class, 'updateShipment'])->name('admin.shipments.update');
        Route::delete('/{shipment}', [AdminController::class, 'destroyShipment'])->name('admin.shipments.destroy');

        // Shipment Routes Management
        Route::post('/{shipment}/routes', [AdminController::class, 'addRoute'])->name('admin.shipments.routes.store');
        Route::put('/{shipment}/routes/{route}', [AdminController::class, 'updateRoute'])->name('admin.shipments.routes.update');
        Route::delete('/{shipment}/routes/{route}', [AdminController::class, 'deleteRoute'])->name('admin.shipments.routes.destroy');
    });

    // Quotes Management
    Route::prefix('quotes')->group(function () {
        Route::get('/', [AdminController::class, 'quotes'])->name('admin.quotes.index');
        Route::get('/{quote}', [AdminController::class, 'showQuote'])->name('admin.quotes.show');
        Route::put('/{quote}', [AdminController::class, 'updateQuote'])->name('admin.quotes.update');
        Route::delete('/{quote}', [AdminController::class, 'destroyQuote'])->name('admin.quotes.destroy');
        Route::post('/{quote}/respond', [AdminController::class, 'respondToQuote'])->name('admin.quotes.respond');
    });

    // Documents Management
    Route::prefix('documents')->group(function () {
        Route::get('/', [AdminController::class, 'documents'])->name('admin.documents.index');
        Route::get('/create', [AdminController::class, 'createDocument'])->name('admin.documents.create');
        Route::post('/', [AdminController::class, 'storeDocument'])->name('admin.documents.store');
        Route::get('/{document}/edit', [AdminController::class, 'editDocument'])->name('admin.documents.edit');
        Route::put('/{document}', [AdminController::class, 'updateDocument'])->name('admin.documents.update');
        Route::delete('/{document}', [AdminController::class, 'destroyDocument'])->name('admin.documents.destroy');
        Route::patch('/{document}/revoke', [AdminController::class, 'revokeDocument'])->name('admin.documents.revoke');
        Route::post('/generate', [AdminController::class, 'generateDocument'])->name('admin.documents.generate');
    });

    // Users Management
    Route::prefix('users')->group(function () {
        Route::get('/', [AdminController::class, 'users'])->name('admin.users.index');
        Route::get('/{user}', [AdminController::class, 'showUser'])->name('admin.users.show');
        Route::put('/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
        Route::patch('/{user}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('admin.users.toggle-admin');
    });

    // Reports and Analytics
    Route::prefix('reports')->group(function () {
        Route::get('/shipments', [AdminController::class, 'shipmentReports'])->name('admin.reports.shipments');
        Route::get('/revenue', [AdminController::class, 'revenueReports'])->name('admin.reports.revenue');
        Route::get('/customer-activity', [AdminController::class, 'customerReports'])->name('admin.reports.customers');
        Route::post('/export', [AdminController::class, 'exportReport'])->name('admin.reports.export');
    });
});

// Fallback route for undefined routes
Route::fallback(function() {
    return view('errors.404');
});

require __DIR__.'/auth.php';
