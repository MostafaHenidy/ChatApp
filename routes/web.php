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
        route::get('/group/{id}', 'group')->name('group');
        route::get('/group/{id}/groupManagement', 'groupManagement')->name('groupManagement');
    });
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
Broadcast::routes(['middleware' => ['auth']]);
