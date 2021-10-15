<?php

use App\Http\Controllers\Wompi\WidgetController;
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
    Route::get('/widget', [WidgetController::class, 'sendData'])->name('widget');
    Route::get('/widget/response', [WidgetController::class, 'checkResult'])->name('widget.response');
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
});
