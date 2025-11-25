<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\ContactController; // ✅ toegevoegd
use Illuminate\Support\Facades\Route;

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

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact-verzenden', [ContactController::class, 'verzenden'])
    ->name('contact.verzenden');

Route::resource('tournaments', TournamentController::class);
Route::resource('admin', AdminController::class);
