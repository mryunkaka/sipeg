<?php

use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MigrationController;

// ===================== DEBUG UNITS =====================

// Cek isi & struktur tabel units
Route::get('/debug-units', function () {
    try {
        $columns = Schema::getColumnListing('units');

        return [
            'env_db'       => env('DB_DATABASE'),
            'config_db'    => config('database.connections.mysql.database'),
            'columns'      => $columns,
            'raw_count'    => DB::table('units')->count(),
            'raw_sample'   => DB::table('units')->select('id', 'nama_unit')->limit(10)->get(),
            'eloq_count'   => Unit::count(),
            'eloq_sample'  => Unit::select('id', 'nama_unit')->limit(10)->get(),
        ];
    } catch (\Throwable $e) {
        return response()->json([
            'status'  => 'error',
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
        ], 500);
    }
});

Route::get('/debug-fix-units', function () {
    return [
        'status'  => 'test-only',
        'version' => 'v3',
        'now'     => now()->toDateTimeString(),
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
