<?php

use App\Models\User;
use Livewire\Volt\Volt;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MigrationController;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::get('/db-check', function () {
    return [
        'env_db'    => env('DB_DATABASE'),
        'config_db' => config('database.connections.mysql.database'),
        'users_count' => User::count(),
        'first_user'  => User::first(),
    ];
});

Route::get('/migration', [MigrationController::class, 'showForm']);
Route::post('/migration', [MigrationController::class, 'run'])->name('migration.run');

Route::get('/', function () {
    return view('welcome');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
