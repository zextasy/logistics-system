<?php


use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\BvdhDocumentController;
use App\Http\Controllers\SpatieDocumentController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\QuoteController;
use App\Http\Controllers\Web\TrackingController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/track', [TrackingController::class, 'showForm'])->name('tracking.form');
Route::post('/track', [TrackingController::class, 'track'])->name('tracking.track');
Route::get('/track/{trackingNumber}', [TrackingController::class, 'show'])->name('tracking.show');
//TODO add other methods from controller
Route::get('/quote', [QuoteController::class, 'create'])->name('quote.create');
Route::post('/quote', [QuoteController::class, 'store'])->name('quote.store');

Route::prefix('spatie')->name('spatie.')->group(function () {
    Route::get('/documents/{document}/preview', [SpatieDocumentController::class, 'preview'])->name('documents.preview');
    Route::get('/documents/{document}/preview-pdf', [SpatieDocumentController::class, 'previewPdf'])->name('documents.preview-pdf');
    Route::get('/documents/{document}/download', [SpatieDocumentController::class, 'download'])->name('documents.download');
});
Route::prefix('bvdh')->name('bvdh.')->group(function () {
    Route::get('/documents/{document}/preview', [BvdhDocumentController::class, 'preview'])->name('documents.preview');
    Route::get('/documents/{document}/preview-pdf', [BvdhDocumentController::class, 'previewPdf'])->name('documents.preview-pdf');
    Route::get('/documents/{document}/download', [BvdhDocumentController::class, 'download'])->name('documents.download');
});
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
        Route::get('/', [QuoteController::class, 'index'])->name('my-quotes.index');
        Route::get('/{quote}', [QuoteController::class, 'show'])->name('my-quotes.show');
        Route::post('/{quote}/attachments', [QuoteController::class, 'attachments'])
            ->name('my-quotes.attachments');
    });

    // Profile
    //Breeze
    Route::get('/my-profile', function () {
        return view('profile');
    })->name('profile');
    //Claude
    //TODO - check usage and delete
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
