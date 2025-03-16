<?php

use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingsController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});


// About page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Game hub
Route::get('/game-hub', function () {
    return view('game-hub');
})->name('game-hub');

// Game routes
Route::get('/games/number-recognition', function () {
    return view('games.number-game');
})->name('games.number');
Route::get('/games/counting-game', function () {
    return view('games.counting-game');
})->name('games.counting');
Route::get('/games/addition-game', function () {
    return view('games.addition-game');
})->name('games.addition');
Route::get('/games/shapes-game', function () {
    return view('games.shapes-game');
})->name('games.shapes');

Route::get('/games/subtraction-game', function () {
    return view('games.subtraction-game');
})->name('games.subtraction');

// Service worker for offline functionality
Route::get('/service-worker.js', function () {
    return response(file_get_contents(public_path('service-worker.js')), 200)
        ->header('Content-Type', 'text/javascript');
});

// Settings routes
Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
Route::post('/settings/save', [SettingsController::class, 'save'])->name('settings.save');
Route::post('/settings/verify-pin', [SettingsController::class, 'verifyPin'])->name('settings.verify-pin');
Route::get('/settings/export-data', [SettingsController::class, 'exportData'])->name('settings.export-data');
Route::post('/settings/import-data', [SettingsController::class, 'importData'])->name('settings.import-data');
Route::post('/settings/reset-data', [SettingsController::class, 'resetData'])->name('settings.reset-data');

// Service worker for offline functionality
Route::get('/service-worker.js', function () {
    return response(file_get_contents(public_path('service-worker.js')), 200)
        ->header('Content-Type', 'text/javascript');
});


// Manifest file for PWA
Route::get('/manifest.json', function () {
    return response()->json([
        'name' => 'NUMZOO',
        'short_name' => 'NUMZOO',
        'start_url' => '/',
        'display' => 'standalone',
        'background_color' => '#F0FFF0',
        'theme_color' => '#4CAF50',
        'orientation' => 'portrait',
        'icons' => [
            [
                'src' => '/images/icons/icon-72x72.png',
                'sizes' => '72x72',
                'type' => 'image/png'
            ],
            [
                'src' => '/images/icons/icon-96x96.png',
                'sizes' => '96x96',
                'type' => 'image/png'
            ],
            [
                'src' => '/images/icons/icon-128x128.png',
                'sizes' => '128x128',
                'type' => 'image/png'
            ],
            [
                'src' => '/images/icons/icon-144x144.png',
                'sizes' => '144x144',
                'type' => 'image/png'
            ],
            [
                'src' => '/images/icons/icon-152x152.png',
                'sizes' => '152x152',
                'type' => 'image/png'
            ],
            [
                'src' => '/images/icons/icon-192x192.png',
                'sizes' => '192x192',
                'type' => 'image/png'
            ],
            [
                'src' => '/images/icons/icon-384x384.png',
                'sizes' => '384x384',
                'type' => 'image/png'
            ],
            [
                'src' => '/images/icons/icon-512x512.png',
                'sizes' => '512x512',
                'type' => 'image/png'
            ]
        ]
    ]);
});

require __DIR__ . '/auth.php';