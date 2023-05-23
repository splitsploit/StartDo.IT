<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'index');

Route::get('login', function() {
    return view('login');
})->name('login');

Route::get('checkout', function() {
    return view('checkout');
})->name('checkout');

Route::get('success-checkout', function() {
    return view('success_checkout');
})->name('success-checkout');