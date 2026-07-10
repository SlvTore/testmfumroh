<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriberController;

Route::get('/', function () {
    return view('welcome');
});

// Subscriber routes
Route::resource('subscribers', SubscriberController::class);
Route::view('/kalkulator', 'kalkulator');
