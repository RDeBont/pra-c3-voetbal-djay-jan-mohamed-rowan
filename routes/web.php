<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\teamController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TournamentCreateController;
use App\Http\Controllers\inschrijfController;
use App\Http\Controllers\FixtureController;
use App\Http\Controllers\ScheidsrechterController;

Route::get('/', function () {
    return view('index');
});

Route::get('/inschrijven', [inschrijfController::class, 'index'])->name('inschrijven.index');
Route::post('/inschrijven', [inschrijfController::class, 'store'])->name('inschrijven.store');


Route::get('/team', function () {
    return view('team');
})->name('team.index');

Route::resource('team', teamController::class);

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact-verzenden', [ContactController::class, 'verzenden'])
    ->name('contact.verzenden');

Route::get('/spelregels', function () {
    return view('spelregels');
});

Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🔐 Admin-only routes
    Route::middleware('admin')->group(function () {
        Route::resource('admin', AdminController::class);
        Route::post('admin/schools/{id}/accept', [AdminController::class, 'accept'])->name('admin.schools.accept');
        Route::post('admin/schools/{id}/reject', [AdminController::class, 'reject'])->name('admin.schools.reject');
    });

    // Other authenticated routes
    Route::delete('/tournaments/{id}', [TournamentController::class, 'destroy']);
    Route::resource('fixtures', FixtureController::class);
    Route::resource('team', TeamController::class);
    Route::resource('users', UserController::class);
    Route::resource('tournaments', TournamentController::class);
    Route::resource('scheidsrechters', ScheidsrechterController::class);

});


Route::resource('tournaments', TournamentController::class)->only(['index', 'show']);
Route::get('tournaments/{tournament}/standings', [TournamentController::class, 'standings'])->name('tournaments.standings');

require __DIR__ . '/auth.php';
