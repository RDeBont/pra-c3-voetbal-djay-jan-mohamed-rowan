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

// Authenticated routes
Route::middleware('auth')->group(function () {

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin-only routes
    Route::middleware('admin')->group(function () {
        Route::resource('admin', AdminController::class);
        Route::post('admin/schools/{id}/accept', [AdminController::class, 'accept'])->name('admin.schools.accept');
        Route::post('admin/schools/{id}/reject', [AdminController::class, 'reject'])->name('admin.schools.reject');

        // Knockouts genereren (admin-only)
        Route::post('/tournaments/{tournament}/generate-knockouts', [TournamentController::class, 'generateKnockouts'])
            ->name('tournaments.generateKnockouts');
    });

    // Other authenticated routes
    Route::delete('/tournaments/{id}', [TournamentController::class, 'destroy'])->name('tournaments.destroy');
    Route::delete('/scheidsrechters/{id}', [ScheidsrechterController::class, 'destroy']);
    Route::resource('fixtures', FixtureController::class);
    Route::resource('team', TeamController::class);
    Route::resource('users', UserController::class);
    Route::resource('tournaments', TournamentController::class);
    Route::resource('scheidsrechters', ScheidsrechterController::class);
});

// Public routes voor tournaments
Route::resource('tournaments', TournamentController::class)->only(['index', 'show']);
Route::get('tournaments/{tournament}/standings', [TournamentController::class, 'standings'])->name('tournaments.standings');

// Knockouts bekijken (publiek)
Route::get('tournaments/{tournament}/knockouts', [TournamentController::class, 'showKnockouts'])->name('tournaments.knockouts');

require __DIR__ . '/auth.php';
