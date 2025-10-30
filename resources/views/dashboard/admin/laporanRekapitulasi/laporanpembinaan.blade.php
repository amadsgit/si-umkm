@extends('layouts.dashboard')
@section('title', 'Laporan & Rekapitulasi')

@section('content')
<div class="p-6 space-y-8">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl shadow-lg p-4 text-white">
        <h2 class="text-3xl font-bold">📊 Laporan & Rekapitulasi</h2>
        <p class="mt-2 text-sm opacity-90">Rekap kegiatan Pembinaan & Konsultasi</p>
    </div>

    {{-- Statistik Ringkas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Card Pembinaan -->
        <div class="bg-white rounded-2xl shadow-md p-5 flex items-center gap-4 hover:shadow-lg transition">
            <div class="bg-emerald-100 p-3 rounded-xl">
                <i class="ph ph-chalkboard-teacher text-emerald-600 text-3xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Pembinaan</p>
                <h3 class="text-2xl font-bold text-emerald-600">{{ $totalPembinaan }}</h3>
            </div>
        </div>
    
        <!-- Card Konsultasi -->
        <div class="bg-white rounded-2xl shadow-md p-5 flex items-center gap-4 hover:shadow-lg transition">
            <div class="bg-blue-100 p-3 rounded-xl">
                <i class="ph ph-chats-circle text-blue-600 text-3xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Konsultasi</p>
                <h3 class="text-2xl font-bold text-blue-600">{{ $totalKonsultasi }}</h3>
            </div>
        </div>
    </div>

    <div class="mb-6 border-b border-gray-200">
        <nav class="flex space-x-8">
            <!-- Tab Pembinaan -->
            <a href="{{ route('dashboard.admin.laporan') }}"
                class="relative pb-3 font-semibold text-sm tracking-wide transition duration-300
                            {{ request()->routeIs('dashboard.admin.laporan') 
                                ? 'text-blue-600 after:w-full' 
                                : 'text-gray-500 hover:text-blue-600 after:w-0 hover:after:w-full' }}
                            after:absolute after:bottom-0 after:left-0 after:h-[3px] after:bg-blue-600 after:rounded-full after:transition-all after:duration-300">
                📘 Laporan Pembinaan
            </a>
        
            <!-- Tab Konsultasi -->
            <a href="{{ route('dashboard.admin.laporankonsultasi') }}"
                class="relative pb-3 font-semibold text-sm tracking-wide transition duration-300
                            {{ request()->routeIs('dashboard.admin.laporankonsultasi') 
                                ? 'text-blue-600 after:w-full' 
                                : 'text-gray-500 hover:text-blue-600 after:w-0 hover:after:w-full' }}
                            after:absolute after:bottom-0 after:left-0 after:h-[3px] after:bg-blue-600 after:rounded-full after:transition-all after:duration-300">
                💬 Laporan Konsultasi
            </a>
        </nav>
    </div>

    {{-- Tabel Pembinaan --}}
    <div class="bg-white rounded-2xl shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">📌 Daftar Kegiatan Pembinaan</h3>
        <div class="flex gap-4 mb-4">
            <a href="{{ route('laporan.admin.exportpembinaan') }}"
                class="px-4 py-2 bg-emerald-500 text-white rounded-lg shadow hover:bg-emerald-600">
                📥 Export Pembinaan
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600 border">
                <thead class="bg-emerald-500 text-white">
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Judul</th>
                        <th class="px-4 py-2">Jenis</th>
                        <th class="px-4 py-2">Topik</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Lokasi</th>
                        <th class="px-4 py-2">Kuota</th>
                        <th class="px-4 py-2">Peserta</th>
                        <th class="px-4 py-2">Dibuat Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembinaan as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $pembinaan->firstItem() + $loop->index }}</td>
                        <td class="px-4 py-2">{{ $item->judul }}</td>
                        <td class="px-4 py-2">{{ $item->jenis->nama_pembinaan ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $item->topik->nama_topik_pembinaan ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $item->tanggal->translatedFormat('d F Y') }}</td>
                        <td class="px-4 py-2">{{ $item->lokasi }}</td>
                        <td class="px-4 py-2">{{ $item->kuota }}</td>
                        <td class="px-4 py-2">{{ $item->peserta_pembinaan_count }}</td>
                        <td class="px-4 py-2">{{ $item->creator->username ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">Belum ada data pembinaan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4 mb-4">
                {{ $pembinaan->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</div>
@endsection