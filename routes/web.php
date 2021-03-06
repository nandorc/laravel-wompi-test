<?php

use App\Http\Controllers\Wompi\ApiController;
use App\Http\Controllers\Wompi\WebCheckoutController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ---------- HOME ---------- //
Route::get('/', function () {
    return view('pages.welcome');
})->name('welcome');

// ---------- WIDGET & WEBCHECKOUT ---------- //
Route::prefix('/widget-webcheckout')->name('widget-webcheckout.')->group(function () {
    Route::get('/', function () {
        return view('pages.widget-webcheckout.index');
    })->name('index');
    Route::get('/{variant}', [WebCheckoutController::class, 'sendData'])->name('variant');
    Route::get('/{variant}/response', [WebCheckoutController::class, 'checkResult'])->name('variant.response');
    Route::get('/{variant}/custom', [WebCheckoutController::class, 'sendData'])->name('variant.custom');
});

// ---------- PLUGINS ---------- //
Route::prefix('/plugins')->name('plugins.')->group(function () {
    Route::get('/', function () {
        return view('pages.plugins.index');
    })->name('index');
});

// ---------- PAYMENT API ---------- //
Route::prefix('/payment-api')->name('payment-api.')->group(function () {
    Route::get('/', function () {
        return view('pages.payment-api.index');
    })->name('index');

    // ---------- ACCEPTANCE TOKEN ---------- //
    Route::get('/acceptance-token', [ApiController::class, 'acceptanceToken'])->name('acceptance-token');

    // ---------- PAYMENT METHODS ---------- //
    Route::prefix('/payment-methods')->name('payment-methods.')->group(function () {
        // ---------- CARD ---------- //
        Route::get('/card', [ApiController::class, 'payUsingCard'])->name('card');
    });
});
