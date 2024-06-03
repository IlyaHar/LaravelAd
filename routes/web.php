<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::prefix('advertisements')->name('advertisements.')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/', [\App\Http\Controllers\AdvertisementController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\AdvertisementController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\AdvertisementController::class, 'store'])->name('store');
        Route::get('/{advertisement}/edit', [\App\Http\Controllers\AdvertisementController::class, 'edit'])->name('edit')->can('update', 'advertisement');
        Route::put('/{advertisement}', [\App\Http\Controllers\AdvertisementController::class, 'update'])->name('update')->can('update', 'advertisement');
        Route::delete('/{advertisement}', [\App\Http\Controllers\AdvertisementController::class, 'destroy'])->name('destroy')->can('delete', 'advertisement');
    });

    Route::get('/{advertisement}', [\App\Http\Controllers\AdvertisementController::class, 'show'])->name('show');
});

Route::prefix('auth')->name('auth.')->middleware('guest')->group(function () {
    Route::get('/github/redirect', function () {
        return \Laravel\Socialite\Facades\Socialite::driver('github')->redirect();
    })->name('github');
    Route::get('/github/callback', [\App\Http\Controllers\AuthController::class, 'loginByGitHub']);

    Route::get('/google/redirect', function () {
        return \Laravel\Socialite\Facades\Socialite::driver('google')->redirect();
    })->name('google');

    Route::get('/google/callback', [\App\Http\Controllers\AuthController::class, 'loginByGoogle']);

});


