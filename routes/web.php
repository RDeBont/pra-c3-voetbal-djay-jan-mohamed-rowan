<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TournamentCreateController;

Route::get('/', function () {
    return view('index');
});

Route::get('/toernooien', function () {
    return view('toernooien');
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


Route::get('/admin/create', [TournamentCreateController::class, 'create'])->name('admin.create');
Route::post('/admin/store', [TournamentCreateController::class, 'store'])->name('admin.store');
