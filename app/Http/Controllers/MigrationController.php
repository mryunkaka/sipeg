<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class MigrationController extends Controller
{
    /**
     * Tampilkan form password migration panel.
     */
    public function showForm()
    {
        // OPTIONAL: Boleh batasi hanya APP_ENV=production atau domain tertentu, dll.
        // if (! app()->environment('production')) abort(404);

        return view('maintenance.migration');
    }

    /**
     * Jalankan migrate + seed setelah password benar.
     */
    public function run(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        $inputPassword  = $request->password;
        $secretPassword = config('app.migration_panel_password', env('MIGRATION_PANEL_PASSWORD'));

        if ($inputPassword !== $secretPassword) {
            return back()
                ->withErrors(['password' => 'Password salah.'])
                ->withInput();
        }

        $logs = [];

        try {
            // 0. Clear config cache (kalau pernah di-cache)
            Artisan::call('config:clear');
            $logs[] = "=== php artisan config:clear ===";
            $logs[] = Artisan::output();

            // 1. DROP semua tabel + migrate ulang + seed ulang
            Artisan::call('migrate:fresh', [
                '--seed'  => true,
                '--force' => true,
            ]);

            $logs[] = "=== php artisan migrate:fresh --seed --force ===";
            $logs[] = Artisan::output();

            $message = "Database berhasil direset & di-seed ulang.";
        } catch (\Throwable $e) {
            $message = "Terjadi error saat menjalankan migration fresh. Cek log aplikasi.";
            $logs[]  = "ERROR: " . $e->getMessage();

            Log::error('[Migration Panel] Error migrate:fresh', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
        }

        return view('maintenance.migration-result', [
            'message' => $message,
            'logs'    => $logs,
        ]);
    }
}
