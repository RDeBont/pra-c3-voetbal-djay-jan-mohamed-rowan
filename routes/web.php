<?php

use App\Http\Controllers\TournamentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TournamentCreateController;

Route::get('/', function () {
    return view('index');
});



Route::get('/inschrijven', function () {
    return view('inschrijven');
});

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/spelregels', function () {
    return view('spelregels');
});

Route::get('/login', function () {
    return view('login');
});


Route::resource('tournaments', TournamentController::class);
