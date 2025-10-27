@extends('layouts.dashboard')
@section('title', 'Riwayat Kegiatan Pembinaan')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-lg space-y-6">
    <h1 class="text-2xl font-bold mb-6 flex items-center gap-3 text-emerald-700">
        Riwayat Kegiatan
    </h1>

    <div class="mb-6 border-b border-gray-200">
        <nav class="flex space-x-6">
            <a href="{{ route('admin.riwayat-kegiatan.konsultasi') }}"
                class="pb-2 border-b-2 {{ request()->routeIs('admin.riwayat-kegiatan.konsultasi') ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-blue-600 hover:border-blue-600' }} font-medium text-sm">
                Kegiatan Konsultasi
            </a>
            <a href="{{ route('admin.riwayat-kegiatan.pembinaan') }}"
                class="pb-2 border-b-2 {{ request()->routeIs('admin.riwayat-kegiatan.pembinaan') ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-blue-600 hover:border-blue-600' }} font-medium text-sm">
                Kegiatan Pembinaan
            </a>
        </nav>
    </div>

    {{-- Tabel Pembinaan --}}
    <div class="bg-white rounded-2xl shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">📌 Moitoring & Riwayat Kegiatan Pembinaan</h3>

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
                        <th class="px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($RiwayatPembinaan as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $RiwayatPembinaan->firstItem() + $loop->index }}</td>
                        <td class="px-4 py-2">{{ $item->judul }}</td>
                        <td class="px-4 py-2">{{ $item->jenis->nama_pembinaan ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $item->topik->nama_topik_pembinaan ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $item->tanggal->translatedFormat('d F Y') }}</td>
                        <td class="px-4 py-2">{{ $item->lokasi }}</td>
                        <td class="px-4 py-2">{{ $item->kuota }}</td>
                        <td class="px-4 py-2">{{ $item->peserta_pembinaan_count }}</td>
                        <td class="px-4 py-2">
                            @if($item->status == 'selesai')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                Selesai
                            </span>
                            @elseif($item->status == 'berjalan')
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                Berjalan
                            </span>
                            @elseif($item->status == 'belum_mulai')
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                Belum Mulai
                            </span>
                            @else
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">
                                {{ ucfirst($item->status ?? '-') }}
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">Belum ada data pembinaan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4 mb-4">
                {{ $RiwayatPembinaan->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</div>
@endsection