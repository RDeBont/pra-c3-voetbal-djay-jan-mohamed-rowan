<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InschrijfController;
use App\Http\Controllers\FixtureController;
use App\Http\Controllers\ScheidsrechterController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', function () {
    return view('index');
});

// Inschrijven
Route::get('/inschrijven', [InschrijfController::class, 'index'])->name('inschrijven.index');
Route::post('/inschrijven', [InschrijfController::class, 'store'])->name('inschrijven.store');

// Team pagina
Route::get('/team', function () {
    return view('team');
})->name('team.index');

Route::resource('team', TeamController::class);

// Contact
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact-verzenden', [ContactController::class, 'verzenden'])->name('contact.verzenden');

// Spelregels
Route::get('/spelregels', function () {
    return view('spelregels');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');

// ================= AUTH =================
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin
    Route::middleware('admin')->group(function () {

        Route::resource('admin', AdminController::class);

        Route::post('admin/schools/{id}/accept', [AdminController::class, 'accept'])
            ->name('admin.schools.accept');

        Route::post('admin/schools/{id}/reject', [AdminController::class, 'reject'])
            ->name('admin.schools.reject');

        // Admin: Tournament routes
        Route::get('/tournaments/create', [TournamentController::class, 'create'])->name('tournaments.create');
        Route::post('/tournaments', [TournamentController::class, 'store'])->name('tournaments.store');
        Route::delete('/tournaments/{tournament}', [TournamentController::class, 'destroy'])->name('tournaments.destroy');

        // Knockouts genereren
        Route::post(
            '/tournaments/{tournament}/generate-knockouts',
            [TournamentController::class, 'generateKnockouts']
        )->name('tournaments.generateKnockouts');

        // Knockouts doorzetten
        Route::post(
            '/tournaments/{tournament}/advance-knockouts',
            [TournamentController::class, 'advanceKnockoutRound']
        )->name('tournaments.advanceKnockouts');
    });

    Route::resource('fixtures', FixtureController::class);
    Route::resource('users', UserController::class);
    Route::resource('scheidsrechters', ScheidsrechterController::class);
});

// =============== PUBLIC TOURNAMENTS ===============
Route::resource('tournaments', TournamentController::class)->only(['index', 'show']);

Route::get(
    '/tournaments/{tournament}/standings',
    [TournamentController::class, 'standings']
)->name('tournaments.standings');

Route::get(
    '/tournaments/{tournament}/knockouts',
    [TournamentController::class, 'showKnockouts']
)->name('tournaments.knockouts');

Route::get(
    '/tournaments/{tournament}/knockouts/public',
    [TournamentController::class, 'showKnockoutsPublic']
)->name('tournaments.knockouts.public');

require __DIR__.'/auth.php';
