<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('form.index');
});
Route::get('/table', function () {
    return view('table.index');
});
