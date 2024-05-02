<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'livewire.pages.home')->name('home');
Route::view('/scores', 'scores')->name('scores');
Route::get('/maps', [App\Http\Controllers\BeatmapsController::class, 'beatmaps'])->name('maps');
Route::view('/users', 'users')->name('users');

Route::prefix('dashboard')->group(function () {
    Route::view('home', 'dashboard')
        ->middleware(['auth', 'verified', 'isAdmin'])
        ->name('dashboard.home');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
