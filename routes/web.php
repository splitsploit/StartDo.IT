<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'index');

Route::get('login', function() {
    return view('login');
})->name('login');

Route::get('checkout', function() {
    return view('checkout');
})->name('checkout');