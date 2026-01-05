<?php

use App\Http\Controllers\costumer;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::controller(CustomerController::class)->group(function () {
    Route::get('/', 'index')->name('customer.index');
    Route::post('/', 'store')->name('customer.store');
});