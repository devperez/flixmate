<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ListController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/contacts', function () {
    return Inertia::render('Contacts');
})->middleware(['auth','verified'])->name('contacts');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/movie/{id}', function ($id) {
    return Inertia::render('MovieDetails', ['id' => $id]);
})->name('movie.details');

Route::get('/tv/{id}', function ($id) {
    return Inertia::render('TVDetails', ['id' => $id]);
})->name('tv.details');

Route::get('/lists', [ListController::class, 'index'])->name('lists.index');
Route::post('/lists', [ListController::class, 'store'])->name('lists.store');
Route::post('/lists/add-movie', [ListController::class, 'addMovie'])->name('lists.add_movie');
Route::get('/lists/{id}', [ListController::class, 'show'])->name('lists.show');

Route::get('/contacts/search', [ContactController::class, 'searchEmail'])->name('contacts.search');
Route::post('/contacts/add', [ContactController::class, 'addContact'])->name('contacts.add');
require __DIR__ . '/auth.php';
