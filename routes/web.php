<?php

use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MigrationController;

Route::get('/debug-units', function () {
    return [
        'env_db'    => env('DB_DATABASE'),
        'env_host'  => env('DB_HOST'),
        'env_user'  => env('DB_USERNAME'),

        'default_connection' => config('database.default'),
        'config_host'        => config('database.connections.mysql.host'),
        'config_db'          => config('database.connections.mysql.database'),
        'config_user'        => config('database.connections.mysql.username'),

        // Hitung dengan query builder mentah
        'raw_count'   => DB::table('units')->count(),
        'raw_sample'  => DB::table('units')->select('id', 'nama_unit')->limit(5)->get(),

        // Hitung dengan Eloquent model Unit
        'eloq_conn'   => (new Unit)->getConnectionName(),
        'eloq_count'  => Unit::count(),
        'eloq_sample' => Unit::select('id', 'nama_unit')->limit(5)->get(),
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
