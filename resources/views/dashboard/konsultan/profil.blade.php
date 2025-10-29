@extends('layouts.dashboard')
@section('title', 'Profil Konsultan')

@section('content')
<div class="p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-emerald-700">Profil Konsultan</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Foto Profil --}} 
        <div class="flex flex-col items-center border border-emerald-500 p-4 rounded-lg shadow">
            <img src="{{ $konsultan->foto_profil ? asset('storage/' . $konsultan->foto_profil) : 'https://via.placeholder.com/150' }}"
                alt="Foto Profil Konsultan" class="w-40 h-40 rounded-full object-cover shadow mb-4">
            <h2 class="text-xl font-semibold text-gray-800">{{ $konsultan->user->username ?? '-' }}</h2>
            <p class="text-gray-500">{{ $konsultan->keahlian ?? '-' }}</p>
        </div>

        {{-- Detail Profil --}}
        <div class="md:col-span-2 bg-white border border-emerald-500 p-6 rounded-lg shadow space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium text-gray-800">{{ $konsultan->user->email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Nomor HP</p>
                    <p class="font-medium text-gray-800">{{ $konsultan->user->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Sertifikasi</p>
                    <p class="font-medium text-gray-800">{{ $konsultan->sertifikasi ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Nomor Sertifikat</p>
                    <p class="font-medium text-gray-800">{{ $konsultan->nomor_sertifikat ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal Sertifikat</p>
                    <p class="font-medium text-gray-800">
                        {{ $konsultan->tanggal_sertifikat ?
                        \Carbon\Carbon::parse($konsultan->tanggal_sertifikat)->translatedFormat('d F Y') : '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Lembaga</p>
                    <p class="font-medium text-gray-800">{{ $konsultan->lembaga ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status Aktif</p>
                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                        {{ $konsultan->status_aktif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $konsultan->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal Terdaftar</p>
                    <p class="font-medium text-gray-800">
                        {{ $konsultan->created_at ? \Carbon\Carbon::parse($konsultan->created_at)->translatedFormat('d F
                        Y') : '-' }}
                    </p>
                </div>
            </div>

            {{-- Bio --}}
            <div class="mt-4">
                <p class="text-sm text-gray-500">Bio</p>
                <p class="font-medium text-gray-800">{{ $konsultan->bio ?? '-' }}</p>
            </div>

            {{-- File Sertifikat --}}
            @if($konsultan->file_sertifikat)
            <div class="mt-4">
                <p class="text-sm text-gray-500">File Sertifikat</p>
                <a href="{{ asset('storage/' . $konsultan->file_sertifikat) }}" target="_blank"
                    class="inline-block px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm rounded-lg shadow">
                    Lihat Sertifikat
                </a>
            </div>
            @endif

            {{-- Tombol Edit --}}
            <div class="pt-4">
                <a href="{{ route('dashboard.konsultan.edit', $konsultan->id) }}"
                    class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg shadow">
                    Edit Profil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection