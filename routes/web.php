<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ListController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatMessageController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('current-user', function () {
    return response()->json(['id' => Auth::id()]);
})->name('current-user');

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
    
    Route::get('/tv/{id}/{type?}', function ($id, $type = null) {
        return Inertia::render('Details', ['id' => $id, 'type' => $type]);
    })->name('tv.details');
    
    Route::get('/lists', [ListController::class, 'index'])->name('lists.index');
    Route::post('/lists', [ListController::class, 'store'])->name('lists.store');
    Route::post('/lists/add-movie', [ListController::class, 'addMovie'])->name('lists.add_movie');
    Route::get('/lists/{id}', [ListController::class, 'show'])->name('lists.show');
    Route::delete('/lists/{id}', [ListController::class, 'destroy'])->name('lists.destroy');
    Route::get('/list/shared-contact', [ListController::class, 'sharedWithContacts'])->name('lists.sharedContacts');
    Route::delete('/delete-movie', [ListController::class, 'delete'])->name('delete-movie');
    
    // Handling contact requests
    Route::get('/contacts/search', [ContactController::class, 'searchEmail'])->name('contacts.search');
    Route::post('/contacts/add', [ContactController::class, 'addContact'])->name('contacts.add');
    Route::get('/contacts/pending', [ContactController::class, 'getPendingRequestsCount'])->name('contacts.pending');
    Route::get('/contacts/connections', [ContactController::class, 'getConnections'])->name('contacts.connections');
    Route::post('/accept-connection', [ContactController::class, 'acceptConnection'])->name('contacts.accept');
    Route::post('/reject-connection', [ContactController::class, 'rejectConnection'])->name('contacts.reject');
    Route::get('/contacts/check/{id}', [ContactController::class, 'checkConnection'])->name('contacts.check');
    Route::post('/share-list', [ContactController::class, 'shareList'])->name('share-list');
    
    Route::get('lists/{list}/chat', [ChatMessageController::class, 'show'])->name('lists.chat.show');
    Route::post('lists/{list}/chat', [ChatMessageController::class, 'store'])->name('lists.chat.store');
    Route::get('lists/{list}/chat/messages', [ChatMessageController::class, 'index'])->name('lists.chat.index');
});

require __DIR__ . '/auth.php';
