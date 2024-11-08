<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/calendar', function () {
    return view('calendar');
});

Route::get('/sleepGraph', function () {
    return view('sleepGraph');
});

Route::get('/post', function () {
    return view('post');
});

