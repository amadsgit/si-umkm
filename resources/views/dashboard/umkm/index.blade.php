@extends('layouts.dashboard')
@section('title', 'Dashboard UMKM')

@section('content')
<div class="p-6 space-y-8">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-emerald-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
        <h1 class="text-3xl font-bold mb-2">
            Selamat datang, {{ $user->username }} 👋
        </h1>
        <p class="text-white/80">
            Berikut rangkuman aktivitas konsultasi & pembinaan UMKM Anda.
        </p>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total Konsultasi --}}
        <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-emerald-500 hover:shadow-lg transition">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-emerald-100 text-emerald-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16h6" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm">Total Konsultasi</h3>
                    <p class="text-2xl font-bold text-emerald-600">{{ $totalKonsultasi }}</p>
                </div>
            </div>
        </div>

        {{-- Konsultasi Selesai --}}
        <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-blue-500 hover:shadow-lg transition">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm">Konsultasi Selesai</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $konsultasiSelesai }}</p>
                </div>
            </div>
        </div>

        {{-- Total Pembinaan --}}
        <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-orange-500 hover:shadow-lg transition">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-orange-100 text-orange-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-3-3v6m9 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm">Total Pembinaan</h3>
                    <p class="text-2xl font-bold text-orange-600">{{ $totalPembinaan }}</p>
                </div>
            </div>
        </div>

        {{-- Pembinaan Selesai --}}
        <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-purple-500 hover:shadow-lg transition">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-purple-100 text-purple-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm">Pembinaan Selesai</h3>
                    <p class="text-2xl font-bold text-purple-600">{{ $pembinaanSelesai }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Info Akun --}}
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Info Akun</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-600">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Telepon:</strong> {{ $user->phone ?? '-' }}</p>
            <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
            <p><strong>Terakhir login:</strong> {{ $user->last_login ?? '-' }}</p>
        </div>
    </div>
</div>
@endsection