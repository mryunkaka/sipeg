@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="bg-white border border-gray-200 rounded-lg shadow p-6">
    <h1 class="text-lg font-semibold text-gray-800">Dashboard</h1>
    <p class="text-sm text-gray-500 mt-1">
        Selamat datang, {{ auth()->user()->name }}!
    </p>

    <div class="mt-4 p-4 bg-blue-50 border border-blue-200 text-blue-800 rounded-lg text-sm">
        Anda sedang mengakses unit:
        <strong>{{ session('active_unit_name') }}</strong>
    </div>
</div>

@endsection
