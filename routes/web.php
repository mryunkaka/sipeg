<?php

use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MigrationController;

Route::get('/test-units', function () {
    // Test raw query
    $raw = DB::select('SELECT * FROM units');

    // Test Eloquent
    $eloquent = \App\Models\Unit::all();

    return response()->json([
        'raw_query' => $raw,
        'eloquent' => $eloquent,
        'connection' => config('database.default'),
        'charset' => config('database.connections.mysql.charset'),
    ]);
});

Route::get('/debug-units-insert', function () {
    $id = DB::table('units')->insertGetId([
        'nama_unit'   => 'DEBUG FROM LARAVEL ' . now()->format('His'),
        'alamat_unit' => 'DEBUG LARAVEL',
        'no_hp_unit'  => '0000000000',
        'logo_unit'   => null,
        'created_at'  => now(),
        'updated_at'  => now(),
    ]);

    return [
        'inserted_id' => $id,
    ];
});

Route::get('/debug-seed-units', function () {
    // HATI-HATI: ini akan menghapus semua data units di DB yang dipakai Laravel
    DB::table('units')->truncate();

    $now = now();

    $units = [
        [
            'nama_unit'   => 'HOTEL HARMONY',
            'alamat_unit' => 'Jl. Raya Batulicin, ...',
            'no_hp_unit'  => '087878987654',
            'logo_unit'   => null,
            'created_at'  => $now,
            'updated_at'  => $now,
        ],
        [
            'nama_unit'   => 'GUESTHOUSE RUMA',
            'alamat_unit' => 'Jl. Suryagandamana, ...',
            'no_hp_unit'  => '087877521992',
            'logo_unit'   => null,
            'created_at'  => $now,
            'updated_at'  => $now,
        ],
        [
            'nama_unit'   => 'HOTEL GALERY',
            'alamat_unit' => 'Jl. Pangeran Hidayat No.26, ...',
            'no_hp_unit'  => '085827191234',
            'logo_unit'   => null,
            'created_at'  => $now,
            'updated_at'  => $now,
        ],
        [
            'nama_unit'   => 'HOTEL KARTIKA',
            'alamat_unit' => 'Jl. Veteran No.2, ...',
            'no_hp_unit'  => '082150942567',
            'logo_unit'   => null,
            'created_at'  => $now,
            'updated_at'  => $now,
        ],
        [
            'nama_unit'   => 'HOTEL LAVENDER',
            'alamat_unit' => 'Jl. Raya provinsi No. km 163, ...',
            'no_hp_unit'  => '085289987654',
            'logo_unit'   => null,
            'created_at'  => $now,
            'updated_at'  => $now,
        ],
    ];

    DB::table('units')->insert($units);

    return [
        'status'      => 'ok',
        'inserted'    => count($units),
        'db_database' => config('database.connections.mysql.database'),
    ];
});

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
