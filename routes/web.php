<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TournamentController;
<<<<<<< HEAD
use App\Http\Controllers\ContactController; // ✅ toegevoegd
use Illuminate\Support\Facades\Route;
=======
use App\Http\Controllers\TournamentCreateController;
>>>>>>> c4a23010d6c035fdc90cfdd03760bf4cbb1ae1d1

Route::get('/', function () {
    return view('index');
});

Route::get('/inschrijven', function () {
    return view('inschrijven');
});

Route::get('/spelregels', function () {
    return view('spelregels');
});

<<<<<<< HEAD
Route::get('/login', function () {
    return view('login');
});

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact-verzenden', [ContactController::class, 'verzenden'])
    ->name('contact.verzenden');
=======
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
>>>>>>> c4a23010d6c035fdc90cfdd03760bf4cbb1ae1d1

Route::resource('tournaments', TournamentController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('admin', AdminController::class);
});

require __DIR__ . '/auth.php';
