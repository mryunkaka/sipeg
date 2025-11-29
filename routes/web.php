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

// Perbaiki & isi ulang data units
Route::get('/debug-fix-units', function () {
    try {
        $now     = now();
        $columns = Schema::getColumnListing('units');

        $seedUnits = [
            'HOTEL HARMONY',
            'GUESTHOUSE RUMA',
            'HOTEL GALERY',
            'HOTEL KARTIKA',
            'HOTEL LAVENDER',
        ];

        DB::beginTransaction();

        // hapus baris korup (nama_unit kosong)
        DB::table('units')
            ->whereNull('nama_unit')
            ->orWhere('nama_unit', '')
            ->delete();

        foreach ($seedUnits as $nama) {
            $data = [
                'nama_unit' => $nama,
            ];

            if (in_array('alamat_unit', $columns)) {
                $data['alamat_unit'] = 'Alamat ' . $nama;
            }

            if (in_array('no_hp_unit', $columns)) {
                $data['no_hp_unit'] = '08xxxxxxxxxx';
            }

            if (in_array('logo_unit', $columns)) {
                $data['logo_unit'] = null;
            }

            if (in_array('created_at', $columns)) {
                $data['created_at'] = $now;
            }

            if (in_array('updated_at', $columns)) {
                $data['updated_at'] = $now;
            }

            DB::table('units')->updateOrInsert(
                ['nama_unit' => $nama],
                $data
            );
        }

        DB::commit();

        return [
            'status'     => 'ok',
            'raw_count'  => DB::table('units')->count(),
            'eloq_count' => Unit::count(),
            'sample'     => Unit::select('id', 'nama_unit')->limit(10)->get(),
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
