<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Migration Result - SIPEG</title>
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

            <span class="hidden sm:inline-flex items-center gap-2 rounded-full bg-zinc-100 px-3 py-1 text-[11px] font-medium text-zinc-700 border border-zinc-200">
                Log Migration
            </span>
        </div>
    </header>

    {{-- Konten --}}
    <main class="flex-1 px-4 sm:px-6 py-8">
        <div class="max-w-5xl mx-auto bg-white/90 border border-zinc-200 shadow-xl shadow-zinc-200/70 rounded-2xl p-6 sm:p-7 space-y-5">

            <h1 class="text-xl sm:text-2xl font-semibold text-zinc-900">
                Hasil Migration &amp; Seeding
            </h1>

            @php
                $isError = str_starts_with($message ?? '', 'Terjadi error');
            @endphp

            <div class="rounded-xl px-4 py-3 text-sm
                {{ $isError
                    ? 'bg-red-50 text-red-800 border border-red-200'
                    : 'bg-emerald-50 text-emerald-800 border border-emerald-200' }}">
                {{ $message ?? 'Tidak ada pesan.' }}
            </div>

            @if(!empty($logs))
                <div class="space-y-2">
                    <h2 class="text-sm font-medium text-zinc-800">Log Artisan</h2>
                    <pre
                        class="bg-zinc-950 text-zinc-100 text-xs rounded-xl p-4 overflow-x-auto max-h-[480px] whitespace-pre-wrap leading-relaxed"
                    >@foreach($logs as $log)
{{ $log . "\n" }}
@endforeach</pre>
                </div>
            @endif

            <div class="flex justify-between items-center pt-2">
                <button
                    type="button"
                    onclick="history.back()"
                    class="text-xs text-blue-600 hover:text-blue-800 font-medium"
                >
                    &larr; Kembali ke panel
                </button>

                <span class="text-[11px] text-zinc-400">
                    {{ now()->format('d/m/Y H:i') }}
                </span>
            </div>
        </div>
    </main>

</body>
</html>
