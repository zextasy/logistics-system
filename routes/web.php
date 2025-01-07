<?php


use App\Http\Controllers\BvdhDocumentController;
use App\Http\Controllers\SpatieDocumentController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\DocumentController;
use App\Http\Controllers\Web\FeedbackController;
use App\Http\Controllers\Web\QuoteController;
use App\Http\Controllers\Web\TrackingController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about-us');
})->name('about');

Route::get('/contact', function () {
    return view('contact-us');
})->name('contact');

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/track', [TrackingController::class, 'showForm'])->name('tracking.form');
Route::post('/track', [TrackingController::class, 'track'])->name('tracking.track');
Route::get('/track/{trackingNumber}', [TrackingController::class, 'show'])->name('tracking.show');
//quotes
Route::get('/quote', [QuoteController::class, 'create'])->name('quote.create');
//feedback
Route::post('/feedback', [FeedbackController::class, 'submit'])->name('feedback.submit');
/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Profile
    Route::get('/my-profile', function () {
        return view('profile');
    })->name('profile');
    //Documents
    Route::prefix('documents')->name('documents.')->group(function () {
        Route::get('/{document}/preview', [DocumentController::class, 'preview'])->name('preview');
        Route::get('/{document}/preview-pdf', [DocumentController::class, 'previewPdf'])->name('preview-pdf');
        Route::get('/{document}/download', [DocumentController::class, 'download'])->name('download');
    });
    //TODO cleanup doc routes
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
});

// Fallback route for undefined routes
Route::fallback(function() {
    return view('errors.404');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
