<?php

use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MigrationController;


/*
|--------------------------------------------------------------------------
| DEBUG UNITS
|--------------------------------------------------------------------------
| Hanya sementara dipakai untuk perbaikan tabel `units` di hosting.
| Setelah beres, silakan dihapus.
*/

// Cek struktur & isi tabel units
Route::get('/debug-units', function () {
    try {
        $columns = Schema::getColumnListing('units');

        return [
            'env_db'      => env('DB_DATABASE'),
            'config_db'   => config('database.connections.mysql.database'),
            'columns'     => $columns,
            'raw_count'   => DB::table('units')->count(),
            'raw_sample'  => DB::table('units')->select('id', 'nama_unit')->limit(10)->get(),
            'eloq_count'  => Unit::count(),
            'eloq_sample' => Unit::select('id', 'nama_unit')->limit(10)->get(),
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

// Isi ulang tabel units
Route::get('/debug-fix-units', function () {
    try {
        $now = now();

        DB::beginTransaction();

        // 1. Putus dulu relasi user -> unit (supaya FK tidak rewel)
        if (Schema::hasColumn('users', 'unit_id')) {
            DB::table('users')->update(['unit_id' => null]);
        }

        // 2. BENAR-BENAR KOSONGKAN TABEL UNITS
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('units')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // 3. ISI ULANG DATA BERSIH
        $rows = [
            [
                'nama_unit'   => 'HOTEL HARMONY',
                'alamat_unit' => 'Jl. Raya Batulicin',
                'no_hp_unit'  => '087878987654',
                'logo_unit'   => null,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nama_unit'   => 'GUESTHOUSE RUMA',
                'alamat_unit' => 'Jl. Suryagandamana',
                'no_hp_unit'  => '087877521992',
                'logo_unit'   => null,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nama_unit'   => 'HOTEL GALERY',
                'alamat_unit' => 'Jl. Pangeran Hidayat',
                'no_hp_unit'  => '085827191234',
                'logo_unit'   => null,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nama_unit'   => 'HOTEL KARTIKA',
                'alamat_unit' => 'Jl. Veteran No.2',
                'no_hp_unit'  => '082150942567',
                'logo_unit'   => null,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nama_unit'   => 'HOTEL LAVENDER',
                'alamat_unit' => 'Jl. Provinsi km 163',
                'no_hp_unit'  => '085289987654',
                'logo_unit'   => null,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        DB::table('units')->insert($rows);

        DB::commit();

        // 4. Ambil sample (sekarang sudah pasti bersih semua)
        $afterCount  = DB::table('units')->count();
        $afterSample = DB::table('units')
            ->select('id', 'nama_unit')
            ->orderBy('id')
            ->limit(10)
            ->get();

        return [
            'status'       => 'ok',
            'after_count'  => $afterCount,
            'after_sample' => $afterSample,
        ];
    } catch (\Throwable $e) {
        DB::rollBack();

        return response()->json([
            'status'  => 'error',
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
        ], 500);
    }
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
