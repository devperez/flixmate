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
Route::get('/list/shared-contact', [ListController::class, 'sharedWithContacts'])->name('lists.sharedContacts');

// Handling contact requests
Route::get('/contacts/search', [ContactController::class, 'searchEmail'])->name('contacts.search');
Route::post('/contacts/add', [ContactController::class, 'addContact'])->name('contacts.add');
Route::get('/contacts/pending', [ContactController::class, 'getPendingRequestsCount'])->name('contacts.pending');
Route::get('/contacts/connections', [ContactController::class, 'getConnections'])->name('contacts.connections');
Route::post('/accept-connection', [ContactController::class, 'acceptConnection'])->name('contacts.accept');
Route::post('/reject-connection', [ContactController::class, 'rejectConnection'])->name('contacts.reject');
Route::post('/share-list', [ContactController::class, 'shareList'])->name('share-list');
require __DIR__ . '/auth.php';
