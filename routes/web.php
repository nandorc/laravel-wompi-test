<?php

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

Route::get('/', function () {
    return view('pages.welcome');
})->name('welcome');
Route::prefix('/widget-webcheckout')->name('widget-webcheckout.')->group(function () {
    Route::get('/', function () {
        return view('pages.widget-webcheckout.index');
    })->name('index');
    Route::get('/widget', function () {
        return view('pages.widget-webcheckout.widget');
    })->name('widget');
});
Route::prefix('/plugins')->name('plugins.')->group(function () {
    Route::get('/', function () {
        return view('pages.plugins.index');
    })->name('index');
});
Route::prefix('/payment-api')->name('payment-api.')->group(function () {
    Route::get('/', function () {
        return view('pages.payment-api.index');
    })->name('index');
});
