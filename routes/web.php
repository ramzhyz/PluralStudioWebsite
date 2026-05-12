<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecoveryController;
use App\Http\Controllers\AthleticsController;
use App\Http\Controllers\LodgeController;
use App\Http\Controllers\SunLoungeController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\PricelistController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CafeController;
use App\Http\Controllers\CheckInController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/recovery', [RecoveryController::class, 'index'])->name('recovery');
Route::get('/athletics', [AthleticsController::class, 'index'])->name('athletics');
Route::get('/lodge', [LodgeController::class, 'index'])->name('lodge');
Route::get('/cafe', [CafeController::class, 'index'])->name('cafe');
Route::get('/sun-lounge', [SunLoungeController::class, 'index'])->name('sunlounge');
Route::get('/production', [ProductionController::class, 'index'])->name('production');
Route::get('/pricelist', [PricelistController::class, 'index'])->name('pricelist');
Route::get('/booking', [BookingController::class, 'index'])->name('booking');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/admin/checkin/{booking}', [CheckInController::class, 'show'])->name('checkin.show');
Route::post('/admin/checkin/{booking}', [CheckInController::class, 'store'])->name('checkin.store');
Route::get('/admin/checkout/{booking}', [CheckInController::class, 'showCheckout'])->name('checkout.show');
Route::post('/admin/checkout/{booking}', [CheckInController::class, 'storeCheckout'])->name('checkout.store');
Route::get('/production/{slug}', [ProductionController::class, 'show'])->name('production.detail');
