<?php

use App\Http\Controllers\SocialLoginController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Route::get('/', function(){
//     return view('pages.home');
// })->name('home');

Volt::route('/', 'page.home')->name('home');

Route::name('auth.')->group(function () {
    Volt::route('/login', 'auth.login')->name('login');
    Volt::route('/register', 'auth.register')->name('register');

    Route::prefix('auth')->group(function () {

        Route::name('google.')->prefix('google')->controller(SocialLoginController::class)->group(function () {
            Route::get('/redirect', 'google_redirect')->name('login');
            Route::get('/callback', 'google_callback');
        });

        Route::name('github.')->prefix('github')->controller(SocialLoginController::class)->group(function () {
            Route::get('/redirect', 'github_redirect')->name('login');
            Route::get('/callback', 'github_callback');
        });

    });
});

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route::middleware(['auth'])->group(function () {
//     Route::redirect('settings', 'settings/profile');

//     Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
//     Volt::route('settings/password', 'settings.password')->name('settings.password');
//     Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
// });

// require __DIR__.'/auth.php';
