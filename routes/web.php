<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::controller(CustomerController::class)->group(function () {
    Route::get('/', 'index')->name('form.index');
    Route::post('/', 'store')->name('form.store');
});

Route::middleware('auth')->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin', 'index')->name('admin.index');
        Route::get('/admin/data', 'data')->name('admin.data');
    });
});

require __DIR__.'/auth.php';
