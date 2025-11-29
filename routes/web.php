<?php

use App\Models\Unit;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MigrationController;

Route::get('/debug-units', function () {
    return [
        'env_db'      => env('DB_DATABASE'),
        'config_db'   => config('database.connections.mysql.database'),
        'units_count' => Unit::count(),
        'sample'      => Unit::take(5)->get(['id', 'nama_unit']),
    ];
});

// ===============================
// 1. AUTH (HALAMAN LOGIN SAJA YANG BEBAS)
// ===============================

// Login form
Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

// Process login
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.attempt')
    ->middleware('guest');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');


// ===============================
// 2. MIGRATION (BEBAS AKSES TANPA LOGIN)
// ===============================

Route::get('/migration', [MigrationController::class, 'showForm']);
Route::post('/migration', [MigrationController::class, 'run'])
    ->name('migration.run');


// ===============================
// 3. PROTECTED PAGES (WAJIB LOGIN)
// ===============================

Route::middleware('auth')->group(function () {

    // Dashboard admin
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Semua halaman lain tambah di sini
    // Contoh:
    // Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');

});


// ===============================
// 4. ROOT: Redirect ke LOGIN jika belum login
// ===============================

Route::get('/', function () {
    return redirect()->route('login');
});
