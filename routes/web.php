<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\costumer;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::controller(CustomerController::class)->group(function () {
    Route::get('/', 'index')->name('form.index');
    Route::post('/', 'store')->name('form.store');
});

Route::controller(AdminController::class)->group(function () {
    Route::get('/admin', 'index')->name('admin.index');
    Route::get('/admin/data', 'data')->name('admin.data');
});