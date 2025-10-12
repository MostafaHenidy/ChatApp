<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;


Route::group([
    'middleware' => ['auth', 'verified'],
    'as' => 'front.',
], function () {
    Route::controller(UserController::class)->group(function () {
        route::get('/', 'index')->name('index');
        route::get('/chat/{id}', 'chat')->name('chat');
    });
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
/**
 * Broadcast Authorization Route
 * * This line registers the /broadcasting/auth endpoint required by Laravel Echo 
 * (and Pusher) to authorize private and presence channels.
 * It must be placed outside of any API middleware group.
 */
Broadcast::routes(['middleware' => ['auth']]);
