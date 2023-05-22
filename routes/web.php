<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'index');

Route::get('login', function() {
    return view('login');
})->name('login');