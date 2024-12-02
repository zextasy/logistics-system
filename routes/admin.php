<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AdminController,
    DashboardController as AdminDashboardController,
    ShipmentController as AdminShipmentController,
    QuoteController as AdminQuoteController,
    DocumentController as AdminDocumentController,
    UserController as AdminUserController,
    ReportController,
    SettingController
};

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
        Route::get('/{shipment}/edit', [AdminShipmentController::class, 'edit'])->name('shipments.edit');
        Route::put('/{shipment}', [AdminShipmentController::class, 'update'])->name('shipments.update');
        Route::delete('/{shipment}', [AdminShipmentController::class, 'destroy'])->name('shipments.destroy');
        Route::put('/{shipment}/routes/{route}', [AdminShipmentController::class, 'updateRoute'])
            ->name('shipments.routes.update');
    });

    // Quotes Management
    Route::prefix('quotes')->group(function () {
        Route::get('/', [AdminQuoteController::class, 'index'])->name('quotes.index');
        Route::get('/{quote}', [AdminQuoteController::class, 'show'])->name('quotes.show');
        Route::post('/{quote}/process', [AdminQuoteController::class, 'process'])->name('quotes.process');
        Route::post('/{quote}/reject', [AdminQuoteController::class, 'reject'])->name('quotes.reject');
        Route::get('/export', [AdminQuoteController::class, 'export'])->name('quotes.export');
        Route::delete('/{quote}', [AdminQuoteController::class, 'destroy'])->name('quotes.destroy');
    });

    // Documents Management
    Route::prefix('documents')->group(function () {
        Route::get('/', [AdminDocumentController::class, 'index'])->name('documents.index');
        Route::get('/create', [AdminDocumentController::class, 'create'])->name('documents.create');
        Route::post('/', [AdminDocumentController::class, 'store'])->name('documents.store');
        Route::get('/{document}', [AdminDocumentController::class, 'show'])->name('documents.show');
        Route::post('/{document}/revoke', [AdminDocumentController::class, 'revoke'])->name('documents.revoke');
        Route::post('/{document}/regenerate', [AdminDocumentController::class, 'regenerate'])
            ->name('documents.regenerate');
    });

    // Users Management
    Route::prefix('users')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::patch('/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])
            ->name('users.toggle-admin');
    });

    // Reports
    Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/export', [ReportController::class, 'export'])->name('reports.export');
        Route::post('/custom', [ReportController::class, 'customReport'])->name('reports.custom');
    });

    // Settings
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/', [SettingController::class, 'update'])->name('settings.update');
        Route::get('/notifications', [SettingController::class, 'notifications'])
            ->name('settings.notifications');
        Route::put('/notifications', [SettingController::class, 'updateNotifications'])
            ->name('settings.notifications.update');
    });
});
