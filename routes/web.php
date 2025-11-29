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

Route::get('/debug-units', function () {
    try {
        if (! Schema::hasTable('units')) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tabel `units` tidak ada.',
            ], 500);
        }

        $envDb    = env('DB_DATABASE');
        $configDb = config('database.connections.mysql.database');

        $columns = DB::select("
            SELECT column_name AS name,
                   data_type   AS type_name,
                   column_type AS type,
                   collation_name AS collation
            FROM information_schema.columns
            WHERE table_schema = schema()
              AND table_name = 'units'
            ORDER BY ordinal_position ASC
        ");

        $rawCount  = DB::table('units')->count();
        $rawSample = DB::select('SELECT id, nama_unit FROM units ORDER BY id ASC LIMIT 10');

        return response()->json([
            'env_db'      => $envDb,
            'config_db'   => $configDb,
            'columns'     => $columns,
            'raw_count'   => $rawCount,
            'raw_sample'  => $rawSample,
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
    } catch (\Throwable $e) {
        return response()->json([
            'status'  => 'error',
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
        ], 500);
    }
});

Route::get('/debug-login-units-final', function () {
    try {
        $envDb  = env('DB_DATABASE');
        $config = config('database.connections.mysql');

        // tes query mentah
        $raw = DB::select('SELECT id, nama_unit FROM units ORDER BY id LIMIT 10');

        // tes via Query Builder
        $qb = DB::table('units')
            ->select('id', 'nama_unit')
            ->orderBy('id')
            ->limit(10)
            ->get();

        // tes via Eloquent
        $eloq = Unit::query()
            ->select('id', 'nama_unit')
            ->orderBy('id')
            ->limit(10)
            ->get();

        $data = [
            'env_db'        => $envDb,
            'config_db'     => $config['database'] ?? null,
            'config_host'   => $config['host'] ?? null,
            'config_user'   => $config['username'] ?? null,

            'raw_count'     => count($raw),
            'raw_sample'    => $raw,

            'qb_count'      => $qb->count(),
            'qb_sample'     => $qb,

            'eloq_count'    => $eloq->count(),
            'eloq_sample'   => $eloq,
        ];

        // pakai flag supaya TIDAK error UTF-8 lagi
        return response()->json(
            $data,
            200,
            [],
            JSON_PRETTY_PRINT
                | JSON_PARTIAL_OUTPUT_ON_ERROR
                | JSON_INVALID_UTF8_SUBSTITUTE
        );
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

// =========================
// DEBUG: HARD RESET UNITS
// =========================
Route::get('/debug-fix-units', function () {
    try {
        // 1. Pastikan tabel units memang ada
        if (! Schema::hasTable('units')) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tabel `units` tidak ditemukan di database.',
            ], 500);
        }

        // 2. Matikan foreign key sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // 3. Kosongkan tabel units (hapus semua baris)
        DB::table('units')->delete();

        // 4. Nyalakan lagi foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // 5. Insert data baru
        $now = now();

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

        // 6. Baca ulang dari database apa adanya
        $afterCount  = DB::table('units')->count();
        $afterSample = DB::select('SELECT id, nama_unit FROM units ORDER BY id ASC LIMIT 10');

        return response()->json([
            'status'       => 'ok',
            'after_count'  => $afterCount,
            'after_sample' => $afterSample,
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
    } catch (\Throwable $e) {
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
