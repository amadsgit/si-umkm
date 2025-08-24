@extends('layouts.dashboard')
@section('title', 'Laporan & Rekapitulasi')

@section('content')
<div class="p-6 space-y-8">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl shadow-lg p-8">
        <h2 class="text-3xl font-bold">📊 Laporan & Rekapitulasi</h2>
        <p class="mt-2 text-sm opacity-90">Rekap kegiatan Pembinaan & Konsultasi Kepala UPTD</p>
    </div>

    {{-- Statistik Ringkas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-md p-6 text-center">
            <p class="text-gray-500 mb-2">Total Pembinaan</p>
            <h3 class="text-3xl font-bold text-emerald-600">{{ $totalPembinaan }}</h3>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 text-center">
            <p class="text-gray-500 mb-2">Total Konsultasi</p>
            <h3 class="text-3xl font-bold text-blue-600">{{ $totalKonsultasi }}</h3>
        </div>
    </div>

    {{-- Tabel Pembinaan --}}
    <div class="bg-white rounded-2xl shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">📌 Daftar Kegiatan Pembinaan</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600 border">
                <thead class="bg-emerald-500 text-white">
                    <tr>
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
        </div>
    </div>

    {{-- Tabel Konsultasi --}}
    <div class="bg-white rounded-2xl shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">📌 Daftar Kegiatan Konsultasi</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600 border">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Waktu</th>
                        <th class="px-4 py-2">Metode</th>
                        <th class="px-4 py-2">Lokasi / Link</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Hasil</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($konsultasi as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-4 py-2">{{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}</td>
                        <td class="px-4 py-2">{{ ucfirst($item->metode) }}</td>
                        <td class="px-4 py-2">{{ $item->lokasi_link ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <span
                                class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $item->status == 'selesai' ? 'bg-green-100 text-green-700' :
                                       ($item->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $item->hasilKonsultasi->ringkasan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">Belum ada data konsultasi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection