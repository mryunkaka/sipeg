<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - SIPEG</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

@php
    $unitName = session('active_unit_name', 'SIPEG');
    $user = auth()->user();
@endphp

<nav class="w-full bg-white border-b border-gray-200 px-4 py-3 flex justify-between items-center shadow-sm">
    <div class="flex items-center gap-2">
        <div class="h-10 w-10 bg-blue-600 text-white rounded-lg flex items-center justify-center font-bold">
            {{ strtoupper(substr($unitName, 0, 2)) }}
        </div>
        <div>
            <p class="text-sm font-semibold text-gray-800">{{ $unitName }}</p>
            <p class="text-xs text-gray-500">Sistem Informasi Penggajian</p>
        </div>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="bg-red-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-red-600">
            Logout
        </button>
    </form>
</nav>

<div class="p-6">
    @yield('content')
</div>

</body>
</html>
