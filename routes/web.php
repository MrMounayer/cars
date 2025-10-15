<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\CarValuationController;
use App\Http\Controllers\VinDecoderController;
use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\ValuationHistoryController;
use App\Http\Controllers\PaymentWebhookController;

// Payment Webhook (no auth required)
Route::get('/webhook/payment', [PaymentWebhookController::class, 'handle'])->name('webhook.payment');

// Payment result pages
Route::middleware(['auth'])->group(function () {
    Route::get('/car-valuation/payment/success/{report}', [CarValuationController::class, 'paymentSuccess'])->name('car-valuation.payment-success');
    Route::get('/car-valuation/payment/failed', [CarValuationController::class, 'paymentFailed'])->name('car-valuation.payment-failed');
    Route::get('/car-valuation/process-payment/{report}', [CarValuationController::class, 'processPayment'])->name('car-valuation.process-payment');
});

// API Token management (admin panel)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/api-tokens', [ApiTokenController::class, 'show'])->name('admin.api-tokens');
    Route::post('/admin/api-tokens', [ApiTokenController::class, 'store'])->name('admin.api-tokens.store');
    Route::delete('/admin/api-tokens/{id}', [ApiTokenController::class, 'destroy'])->name('admin.api-tokens.destroy');
});
use Illuminate\Http\Request;

// --- API Endpoints ---
Route::prefix('api')->middleware('auth:sanctum')->group(function () {
    // Car Valuation API
    Route::post('/car-valuation', function (Request $request) {
        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'mileage' => 'required|integer|min:0',
        ]);
        $service = new \App\Services\CarValuationService();
        $valuation = $service->getValuation(
            $validated['make'],
            $validated['model'],
            $validated['year'],
            $validated['mileage'] ?? null
        );
        return response()->json([
            'valuation' => $valuation,
            'data' => $validated,
        ]);
    });

    // VIN Decoder API
    Route::post('/vin-decode', function (Request $request) {
        $validated = $request->validate([
            'vin' => 'required|string|size:17',
        ]);
        $service = new \App\Services\VinDecoderService();
        $results = $service->decode($validated['vin']);
        return response()->json([
            'vin' => $validated['vin'],
            'results' => $results,
        ]);
    });
});





Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('reports', [\App\Http\Controllers\ReportHistoryController::class, 'index'])->name('reports');

Route::middleware(['auth'])->group(function () {
    // Admin panel: Car Valuation & VIN Decoder
    Route::get('/valuation', [CarValuationController::class, 'showForm'])->name('car-valuation.form');
    Route::post('/car-valuation', [CarValuationController::class, 'submitForm'])->name('car-valuation.submit');
    Route::get('/car-valuation/payment', [CarValuationController::class, 'payment'])->name('car-valuation.payment');
    
    // Valuation History Routes
    Route::get('/valuation/history', [ValuationHistoryController::class, 'index'])->name('valuation.history');
    Route::get('/valuation/{report}', [ValuationHistoryController::class, 'show'])->name('valuation.show');
    Route::get('/car-valuation/result', [CarValuationController::class, 'showResult'])->name('car-valuation.showResult');
    Route::get('/vin-decode', [VinDecoderController::class, 'showForm'])->name('vin.form');
    Route::post('/vin-decode', [VinDecoderController::class, 'decode'])->name('vin.decode');

    // Report history dashboard
    Route::get('/dashboard/reports', [\App\Http\Controllers\ReportHistoryController::class, 'index'])->name('dashboard.reports');

    // VIN PDF download
    Route::post('/vin-decode/pdf', [\App\Http\Controllers\VinDecoderPdfController::class, 'download'])->name('vin.decode.pdf');

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});



// Explicitly include auth routes
require __DIR__.'/auth.php';


