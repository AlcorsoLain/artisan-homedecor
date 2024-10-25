<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\TumblrAuthController;

Route::get('/', function () {
    return view('home');
});
Route::get('/debugger', function () {
    return view('debugger');
});

Route::get('/auth/tumblr', [TumblrAuthController::class, 'redirectToProvider']);
Route::get('/auth/callback', [TumblrAuthController::class, 'handleProviderCallback']);
Route::get('/auth/tumblr/logout', [TumblrAuthController::class, 'handleProviderLogout']);
