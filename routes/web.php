<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\CrewController;
use App\Http\Controllers\MarineController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
Route::get('/crews/{crew:slug}', [CrewController::class, 'show'])->name('crews.show');
Route::get('/marines', [MarineController::class, 'index'])->name('marines.index');
Route::get('/marines/{marine}', [MarineController::class, 'show'])->name('marines.show');
Route::get('/world-government', function () {
    return Inertia::render('WorldGovernment/Index');
})->name('world-government');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
