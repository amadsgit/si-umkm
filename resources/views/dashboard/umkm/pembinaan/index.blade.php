@extends('layouts.dashboard')
@section('title', 'Jadwal Pembinaan')

@section('content')
<div class="p-6 space-y-8">
    <div class="mb-6 border-b border-gray-200">
        <nav class="flex space-x-6">
            <a href="{{ route('dashboard.umkm.pembinaan.index') }}"
                class="pb-2 border-b-2 {{ request()->routeIs('dashboard.umkm.pembinaan.index') ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-blue-600 hover:border-blue-600' }} font-medium text-sm">
                Daftar Jadwal Pembinaan
            </a>
    
            <a href="{{ route('dashboard.umkm.pembinaan.listpembinaan') }}"
                class="pb-2 border-b-2 {{ request()->routeIs('dashboard.umkm.pembinaan.listpembinaan') ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-blue-600 hover:border-blue-600' }} font-medium text-sm">
                Kegiatan Pembinaan Saya
            </a>
        </nav>
    </div>

    <h1 class="text-3xl font-bold text-emerald-700 mb-6 flex items-center gap-2">
        📅 Jadwal Pembinaan UMKM
    </h1>

    @if($jadwalPembinaanList->isEmpty())
    <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-6 py-4 rounded-lg shadow text-center">
        Belum ada jadwal pembinaan yang tersedia.
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($jadwalPembinaanList as $jadwal)
        <div class="group relative bg-gradient-to-br from-sky-50 via-white to-emerald-100
                        rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300
                        overflow-hidden flex flex-col">

            <!-- Badge tanggal -->
            <div
                class="absolute top-4 right-4 bg-emerald-600 text-white px-3 py-1 text-xs font-semibold rounded-full shadow">
                {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d M Y') }}
            </div>

            <!-- Card content -->
            <div class="p-6 flex flex-col flex-1 justify-between">
                <div class="mb-4">
                    <h2 class="text-xl font-bold text-gray-800 mt-4 mb-3 group-hover:text-emerald-700 transition"><i class="ph ph-chalkboard-teacher text-emerald-600 text-2xl"></i>
                        {{ $jadwal->judul ?? 'Pembinaan UMKM' }}
                    </h2>
                    <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                        {{ $jadwal->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}
                    </p>

                    <div class="space-y-3 text-sm text-gray-700">
                        <p class="flex items-center font-bold gap-2">
                            <i class="ph ph-calendar-blank text-emerald-600 text-lg"></i>
                            {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }}
                        </p>
                        <p class="flex items-center font-bold gap-2">
                            <i class="ph ph-clock text-emerald-600 text-lg"></i>
                            {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }} WIB
                        </p>
                        <p class="flex items-center font-bold gap-2">
                            <i class="ph ph-globe text-emerald-600 text-lg"></i>
                            {{ ucfirst($jadwal->metode) ?? 'Metode belum ditentukan' }}
                        </p>
                        <p class="flex items-center font-bold gap-2">
                            <i class="ph ph-map-pin-line text-emerald-600 text-lg"></i>
                            {{ $jadwal->lokasi ?? 'Lokasi belum ditentukan' }}
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="ph ph-users-three text-emerald-600 text-lg"></i>
                            {{ $jadwal->peserta_pembinaan_count }} Peserta terdaftar
                            <span class="text-gray-500">/ {{ $jadwal->kuota }} kuota</span>
                        </p>
                    </div>
                </div>

                <form action="{{ route('dashboard.umkm.pembinaan.apply', $jadwal->id) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda ingin mengikuti pembinaan ini?')">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center w-full bg-emerald-600 text-white px-4 py-2
                               rounded-xl font-medium hover:bg-emerald-700 transform hover:scale-[1.02] transition-all
                               focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 cursor-pointer">
                        Ikuti Pembinaan
                        <i class="ph-arrow-right ml-2 text-white text-lg"></i>
                    </button>
                </form>
            </div>

        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection