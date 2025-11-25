<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TournamentCreateController;
<<<<<<< Updated upstream
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FixtureController;

=======
>>>>>>> Stashed changes

Route::get('/', function () {
    return view('index');
});

Route::get('/inschrijven', function () {
    return view('inschrijven');
});

Route::get('/spelregels', function () {
    return view('spelregels');
});

<<<<<<< Updated upstream
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact-verzenden', [ContactController::class, 'verzenden'])
    ->name('contact.verzenden');

=======
>>>>>>> Stashed changes
Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('tournaments', TournamentController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('admin', AdminController::class);
    Route::resource('fixtures', FixtureController::class);
});

require __DIR__ . '/auth.php';
