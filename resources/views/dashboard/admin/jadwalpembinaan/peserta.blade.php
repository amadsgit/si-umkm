@extends('layouts.dashboard')
@section('title', 'Peserta Jadwal Pembinaan')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-lg space-y-6">

    {{-- Header: judul kiri, tombol kembali kanan --}}
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-emerald-700">
            Peserta Pembinaan: {{ $jadwal->judul }}
        </h1>
        <a href="{{ route('admin.jadwal-pembinaan.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 transition"
            title="Kembali ke daftar jadwal">
            <i class="ph ph-arrow-left"></i>
            <span class="hidden sm:inline">Kembali</span>
        </a>
    </div>

    <div class="overflow-x-auto overflow-y-hidden">
        <table class="min-w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-3 py-2 border text-left">No</th>
                    <th class="px-3 py-2 border text-left">Nama User</th>
                    <th class="px-3 py-2 border text-left">Nama UMKM</th>
                    <th class="px-3 py-2 border text-left">Rekap Absensi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesertaList as $i => $peserta)
                <tr class="border-t hover:bg-gray-50">
                    {{-- Nomor urut konsisten antar halaman --}}
                    <td class="px-3 py-2 border">
                        {{ $pesertaList->firstItem() + $i }}
                    </td>

                    {{-- Nama User --}}
                    <td class="px-3 py-2 border">
                        {{ $peserta->umkm->user->username ?? '-' }}
                    </td>

                    {{-- Nama UMKM --}}
                    <td class="px-3 py-2 border">
                        {{ $peserta->umkm->nama_usaha ?? '-' }}
                    </td>

                    {{-- Rekap Absensi --}}
                    <td class="px-3 py-2 border">
                        @if($peserta->status_kehadiran === 'hadir')
                        <span class="px-2 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">Hadir</span>
                        @elseif($peserta->status_kehadiran === 'tidak_hadir')
                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Tidak Hadir</span>
                        @else
                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700">Belum Absensi</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-3 py-4 text-center text-gray-500">
                        Belum ada peserta.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-4 mb-4">
            {{ $pesertaList->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
@endsection