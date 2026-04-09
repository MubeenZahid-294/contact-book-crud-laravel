<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;

Route::get('/', fn() => redirect()->route('contacts.index'));

Route::middleware('auth')->group(function () {   
Route::get('profile',           [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('profile',           [ProfileController::class, 'update'])->name('profile.update');
Route::put('profile/password',  [ProfileController::class, 'updatePassword'])->name('profile.password');
Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');    
Route::prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/',             [NotificationController::class, 'index'])->name('index');
    Route::get('/count',        [NotificationController::class, 'count'])->name('count');
    Route::post('/mark-all',    [NotificationController::class, 'markAllRead'])->name('markAll');
    Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
});
    Route::get('contacts/export', [ContactController::class, 'export'])
     ->name('contacts.export');
     Route::get('stats', [ContactController::class, 'stats'])
     ->name('contacts.stats');
    Route::resource('contacts', ContactController::class);
    Route::post('contacts/{contact}/favorite', [ContactController::class, 'toggleFavorite'])
         ->name('contacts.favorite');
     Route::resource('tags', TagController::class)->only(['index', 'store', 'destroy']);
});

require __DIR__.'/auth.php';