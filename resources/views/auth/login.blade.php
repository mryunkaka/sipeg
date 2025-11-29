<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login SIPEG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white shadow-lg border border-gray-200 rounded-xl p-6">

        <div class="text-center mb-6">
            <div class="mx-auto h-12 w-12 rounded-lg bg-blue-600 text-white flex items-center justify-center text-xl font-bold">
                SG
            </div>
            <h2 class="mt-3 text-xl font-semibold text-gray-900">SIPEG</h2>
            <p class="text-xs text-gray-500">Sistem Informasi Penggajian</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 text-sm font-medium">Email</label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       class="w-full border-gray-300 rounded-lg text-sm p-2.5"
                       required autofocus>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">Password</label>
                <input type="password" name="password"
                       class="w-full border-gray-300 rounded-lg text-sm p-2.5"
                       required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">Pilih Unit</label>

                <select name="unit_id"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5"
                        required
                        style="color:#111827; background:#ffffff;"> {{-- paksa warna teks --}}
                    <option value="" disabled {{ old('unit_id') ? '' : 'selected' }}>-- Pilih Unit --</option>

                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" style="color:#111827;">
                            {{ $unit->nama_unit }}
                        </option>
                    @endforeach
                </select>

                {{-- DEBUG KECIL: kasih info kalau units kosong --}}
                @if(isset($unitsCount) && $unitsCount === 0)
                    <p class="mt-1 text-xs text-red-600">
                        (Debug) Tidak ada data unit yang dikirim ke view.
                    </p>
                @endif
            </div>
            <button type="submit"
                class="w-full bg-blue-600 text-white p-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">
                Masuk
            </button>
        </form>

        <p class="mt-4 text-center text-xs text-gray-400">© {{ date('Y') }} SIPEG</p>
    </div>

</body>
</html>
