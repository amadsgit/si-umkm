@extends('layouts.dashboard')
@section('title', 'Riwayat Kegiatan Konsultasi')

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

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">📌 Riwayat Kegiatan Konsultasi</h3>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600 border">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="px-3 py-2 ">No</th>
                        <th class="px-3 py-2 ">UMKM</th>
                        <th class="px-3 py-2 ">Topik</th>
                        <th class="px-3 py-2 ">Konsultan</th>
                        <th class="px-3 py-2 ">Tanggal</th>
                        <th class="px-3 py-2 ">Metode</th>
                        <th class="px-3 py-2 ">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($RiwayatKonsultasi as $item)
                    <tr>
                        <td class=" px-3 py-2">{{ $RiwayatKonsultasi->firstItem() + $loop->index }}</td>
                        <td class=" px-3 py-2">{{ $item->umkm->nama_usaha }}</td>
                        <td class=" px-3 py-2">{{ $item->topik->nama_topik }}</td>
                        <td class=" px-3 py-2">{{ $item->konsultan->user->username ?? '-' }}</td>
                        <td class=" px-3 py-2">{{ optional($item->jadwal)->tanggal ?? '-' }}</td>
                        <td class=" px-3 py-2">{{ optional($item->jadwal)->metode ?
                            ucfirst(optional($item->jadwal)->metode) : '-' }}</td>
                        <td class=" px-3 py-2">
                            {{-- tampilkan status --}}
                            @if($item->status == 'disetujui' && optional($item->jadwal)->status == 'selesai')
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded">Selesai</span>
                            @elseif($item->status == 'disetujui')
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">Disetujui</span>
                            @else
                            <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-3">Tidak ada riwayat konsultasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4 mb-4">
                {{ $RiwayatKonsultasi->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</div>
@endsection