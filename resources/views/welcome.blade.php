<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>SIPEG – Sistem Penggajian</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-900 text-slate-100 flex items-center justify-center">
    <div class="max-w-xl w-full px-6 py-8 bg-slate-800/80 rounded-2xl shadow-xl border border-slate-700">
        <h1 class="text-2xl font-semibold text-orange-400 mb-2">
            SIPEG – Sistem Penggajian
        </h1>
        <p class="text-sm text-slate-300 mb-6">
            Aplikasi pengelolaan absensi dan penggajian karyawan Harikenangan Group.
        </p>

        <div class="space-y-3">
            <a href="{{ url('/admin/login') }}"
               class="inline-flex items-center justify-center w-full px-4 py-2.5 rounded-xl
                      bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium
                      transition">
                Masuk sebagai Admin
            </a>

            <p class="text-[11px] text-slate-400 text-center">
                © {{ now()->year }} Harikenangan Group – SIPEG.
            </p>
        </div>
    </div>
</body>
</html>
