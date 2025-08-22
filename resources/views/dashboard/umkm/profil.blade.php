@extends('layouts.dashboard')
@section('title', 'Profil UMKM')

@section('content')
<div class="p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold  mb-6 text-emerald-700">Profil UMKM</h1>

    @foreach($umkmList as $umkm)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Foto Profil --}}
        <div class="flex flex-col items-center border border-emerald-500 p-4 rounded-lg shadow">
            <img src="{{ $umkm->foto_profil ? asset('storage/' . $umkm->foto_profil) : 'https://via.placeholder.com/150' }}"
                alt="Foto Profil UMKM" class="w-40 h-40 rounded-full object-cover shadow mb-4">
            <h2 class="text-xl font-semibold text-gray-800">{{ $umkm->nama_usaha }}</h2>
            <p class="text-gray-500">{{ $umkm->bidang_usaha }}</p>
        </div>

        {{-- Detail Profil --}}
        <div class="md:col-span-2 bg-white border border-emerald-500 p-6 rounded-lg shadow space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Alamat Usaha</p>
                    <p class="font-medium text-gray-800">{{ $umkm->alamat_usaha }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tahun Berdiri</p>
                    <p class="font-medium text-gray-800">{{ $umkm->tahun_berdiri }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kategori Usaha</p>
                    <p class="font-medium text-gray-800">{{ $umkm->kategori_usaha }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pemilik</p>
                    <p class="font-medium text-gray-800">{{ $umkm->user->username ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tgl Terdaftar</p>
                    <p class="font-medium text-gray-800">{{ $umkm->created_at ? \Carbon\Carbon::parse($umkm->created_at)->translatedFormat('d F Y') : '-' }}</p>
                </div>
            </div>

            {{-- Tombol Edit --}}
            <div class="pt-4">
                <a href="{{ route('dashboard.umkm.edit', $umkm->id) }}"
                    class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg shadow">
                    Edit Profil
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection