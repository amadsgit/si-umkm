@extends('layouts.dashboard')
@section('title', 'Dashboard Konsultan')

@section('content')
<div class="p-6 space-y-8">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-emerald-500 to-green-600 rounded-2xl shadow-lg p-8 text-white">
        <h6 class="text-3xl font-bold mb-2">
            Selamat datang, {{ $user->username }} 👋
        </h6>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        {{-- Total Konsultasi --}}
        <div
            class="bg-white rounded-xl shadow-md p-6 border-t-4 border-emerald-500 hover:shadow-xl transition duration-200">
            <div class="flex items-center space-x-4">
                <div class="p-4 bg-emerald-100 text-emerald-600 rounded-full">
                    <i class="ph ph-chats text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm font-medium">Total Konsultasi</h3>
                    <p class="text-3xl font-bold text-emerald-600">{{ $totalKonsultasi }}</p>
                </div>
            </div>
        </div>

        {{-- Konsultasi Selesai --}}
        <div
            class="bg-white rounded-xl shadow-md p-6 border-t-4 border-blue-500 hover:shadow-xl transition duration-200">
            <div class="flex items-center space-x-4">
                <div class="p-4 bg-blue-100 text-blue-600 rounded-full">
                    <i class="ph ph-check-circle text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm font-medium">Konsultasi Selesai</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $konsultasiSelesai }}</p>
                </div>
            </div>
        </div>

        {{-- (Optional) Konsultasi Berlangsung --}}
        <div
            class="bg-white rounded-xl shadow-md p-6 border-t-4 border-yellow-500 hover:shadow-xl transition duration-200">
            <div class="flex items-center space-x-4">
                <div class="p-4 bg-yellow-100 text-yellow-600 rounded-full">
                    <i class="ph ph-hourglass text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm font-medium">Sedang Berlangsung</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $konsultasiBerlangsung ?? 0 }}</p>
                </div>
            </div>
        </div>

        {{-- (Optional) Konsultasi Mendatang --}}
        <div
            class="bg-white rounded-xl shadow-md p-6 border-t-4 border-purple-500 hover:shadow-xl transition duration-200">
            <div class="flex items-center space-x-4">
                <div class="p-4 bg-purple-100 text-purple-600 rounded-full">
                    <i class="ph ph-calendar-check text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm font-medium">Jadwal Mendatang</h3>
                    <p class="text-3xl font-bold text-purple-600">{{ $konsultasiMendatang ?? 0 }}</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Info Akun --}}
    <div class="bg-white rounded-2xl shadow-md p-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-6">Informasi Akun</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-6 text-gray-700">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Telepon:</strong> {{ $user->phone ?? '-' }}</p>
            <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
            <p><strong>Terakhir Login:</strong> {{ $user->last_login ?? '-' }}</p>
        </div>
    </div>

</div>
@endsection