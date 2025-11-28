<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Migration Panel - SIPEG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-zinc-100/80 text-zinc-900 flex flex-col">

    {{-- Top bar --}}
    <header class="w-full border-b border-zinc-200 bg-white/90 backdrop-blur">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-blue-600 text-white text-sm font-semibold shadow-sm">
                    SG
                </span>
                <div class="leading-tight">
                    <p class="text-sm font-semibold text-zinc-800">SIPEG</p>
                    <p class="text-xs text-zinc-500">Sistem Informasi Penggajian</p>
                </div>
            </div>

            <span class="hidden sm:inline-flex items-center gap-2 rounded-full bg-amber-50 px-3 py-1 text-[11px] font-medium text-amber-800 border border-amber-200">
                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                Maintenance mode · Migration
            </span>
        </div>
    </header>

    {{-- Konten tengah --}}
    <main class="flex-1 flex items-center justify-center px-4 sm:px-6 py-10">
        <div class="w-full max-w-lg rounded-2xl bg-white shadow-xl shadow-zinc-200/70 border border-zinc-200 px-6 py-7 sm:px-7 sm:py-8 space-y-6">

            {{-- Judul + deskripsi --}}
            <div class="space-y-1.5">
                <h1 class="text-xl sm:text-2xl font-semibold text-zinc-900">
                    Migration Panel SIPEG
                </h1>
                <p class="text-sm text-zinc-600 leading-relaxed">
                    Panel ini akan menjalankan
                    <span class="font-semibold">php artisan migrate --force</span>
                    dan
                    <span class="font-semibold">php artisan db:seed --force</span>
                    pada database yang dikonfigurasi di file
                    <code class="font-mono text-[11px] bg-zinc-100 px-1.5 py-0.5 rounded border border-zinc-200 align-middle">
                        .env
                    </code>.
                </p>
            </div>

            {{-- Peringatan --}}
            <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-xs text-amber-900 space-y-1.5">
                <p class="font-semibold flex items-center gap-2">
                    <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-amber-500 text-[11px] text-white">
                        !
                    </span>
                    Peringatan
                </p>
                <p class="leading-relaxed">
                    Jalankan hanya bila diperlukan. Setelah proses berhasil,
                    sebaiknya nonaktifkan atau hapus route panel ini agar tidak bisa diakses sembarang orang.
                </p>
            </div>

            {{-- Form password --}}
            <form method="POST" action="{{ route('migration.run') }}" class="space-y-4">
                @csrf

                <div class="space-y-1.5">
                    <label for="password" class="block text-sm font-medium text-zinc-800">
                        Password Panel
                    </label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="off"
                        class="block w-full rounded-lg border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900 shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan password rahasia…"
                    >

                    @error('password')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white
                           shadow-sm hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2
                           focus-visible:ring-offset-white transition-colors"
                >
                    Jalankan Migration &amp; Seeding
                </button>
            </form>

            <p class="text-[11px] text-zinc-400 text-center pt-1">
                Versi panel ini hanya untuk keperluan deployment internal. Jangan dibagikan ke publik.
            </p>
        </div>
    </main>

</body>
</html>
