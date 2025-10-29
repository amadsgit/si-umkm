@extends('layouts.dashboard')
@section('title', 'Profil Kepala UPTD')

@section('content')
<div class="p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-emerald-700">Profil Kepala UPTD</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Foto Profil --}}
        <div class="flex flex-col items-center border border-emerald-500 p-4 rounded-lg shadow">
            <img src="{{ $kepalauptd->foto_profil ? asset('storage/' . $kepalauptd->foto_profil) : 'https://via.placeholder.com/150' }}"
                alt="Foto Profil Kepala UPTD" class="w-40 h-40 rounded-full object-cover shadow mb-4">
            <h2 class="text-xl font-semibold text-center text-gray-800">{{ $kepalauptd->user->username ?? '-' }}</h2>
            <p class="text-gray-500">{{ $kepalauptd->jabatan ?? '-' }}</p>
        </div>

        {{-- Detail Profil --}}
        <div class="md:col-span-2 bg-white border border-emerald-500 p-6 rounded-lg shadow space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">NIP</p>
                    <p class="font-medium text-gray-800">{{ $kepalauptd->nip ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium text-gray-800">{{ $kepalauptd->user->email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Nomor HP</p>
                    <p class="font-medium text-gray-800">{{ $kepalauptd->user->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status Aktif</p>
                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                        {{ $kepalauptd->status_aktif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $kepalauptd->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
            </div>

            {{-- Tombol Edit --}}
            <div class="pt-4">
                <a href="{{ route('dashboard.kepalauptd.edit', $kepalauptd->id) }}"
                    class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg shadow">
                    Edit Profil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection