<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\CarValuationController;
use App\Http\Controllers\VinDecoderController;



// VIN Decoder
Route::get('/vin-decode', [VinDecoderController::class, 'showForm'])->name('vin.form');
Route::post('/vin-decode', [VinDecoderController::class, 'decode'])->name('vin.decode');

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::get('/car-valuation', [CarValuationController::class, 'showForm'])->name('car-valuation.form');
Route::post('/car-valuation', [CarValuationController::class, 'submitForm'])->name('car-valuation.submit');


