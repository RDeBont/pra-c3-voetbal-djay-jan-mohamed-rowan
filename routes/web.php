<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TournamentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TournamentCreateController;
use App\Http\Controllers\FixtureController;

Route::get('/', function () {
    return view('index');
});

Route::get('/inschrijven', function () {
    return view('inschrijven');
});

Route::get('/spelregels', function () {
    return view('spelregels');
});

Route::get('/login', function () {
    return view('login');
});


Route::resource('tournaments', TournamentController::class);
Route::resource('admin', AdminController::class);
Route::resource('fixtures', FixtureController::class);
