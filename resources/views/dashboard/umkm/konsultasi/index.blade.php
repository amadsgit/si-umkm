@extends('layouts.dashboard')
@section('title', 'Konsultasi UMKM')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-lg space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-emerald-700">Permintaan Konsultasi</h1>
        <a href="{{ route('dashboard.umkm.konsultasi.create') }}"
            class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow transition">
            <i class="ph ph-plus-circle text-lg mr-2"></i> Ajukan Konsultasi
        </a>
    </div>

    {{-- Info Panduan --}}
    <div class="bg-emerald-50 border border-emerald-200 p-4 rounded-lg text-sm text-emerald-800">
        Ajukan permintaan konsultasi dengan memilih topik yang sesuai.
        Setelah disetujui admin, jadwal dan konsultan akan ditentukan,
        dan Anda akan menerima notifikasi.
    </div>

    {{-- Permintaan Belum Selesai --}}
    <h2 class="text-lg font-semibold text-gray-700 mt-6 mb-4">Proses & Menunggu</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
        @forelse($permintaanList->where('status', '!=', 'selesai') as $permintaan)
        @include('dashboard.umkm.konsultasi._card', ['permintaan' => $permintaan])
        @empty
        <div class="col-span-full text-center text-gray-500 py-6">
            Tidak ada permintaan konsultasi yang sedang berjalan.
        </div>
        @endforelse
    </div>

    {{-- Permintaan Ditolak --}}
    <h2 class="text-lg font-semibold text-gray-700 mt-8 mb-4">Permintaan Ditolak</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg mt-2">
            <thead class="bg-gray-50 text-gray-700 text-sm">
                <tr>
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Topik</th>
                    <th class="px-4 py-2 border">Konsultan</th>
                    <th class="px-4 py-2 border">Tanggal</th>
                    <th class="px-4 py-2 border">Status</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($ditolakList as $item)
                <tr class="hover:bg-gray-50 align-top">
                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border">{{ $item->topik->nama_topik }}</td>
                    <td class="px-4 py-2 border">{{ $item->konsultan->user->username ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $item->created_at->format('d F Y') }}</td>
                    <td class="px-4 py-2 border">
                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-medium">Ditolak</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-500 py-4">Belum ada permintaan yang ditolak.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Permintaan Selesai --}}
    <h2 class="text-lg font-semibold text-gray-700 mt-8">Riwayat Konsultasi Selesai</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg mt-2">
            <thead class="bg-gray-50 text-gray-700 text-sm">
                <tr>
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Topik</th>
                    <th class="px-4 py-2 border">Konsultan</th>
                    <th class="px-4 py-2 border">Tanggal</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Ringkasan</th>
                    <th class="px-4 py-2 border">Solusi</th>
                    <th class="px-4 py-2 border">Lampiran</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($riwayatList as $item)
                <tr class="hover:bg-gray-50 align-top">
                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border">{{ $item->topik->nama_topik }}</td>
                    <td class="px-4 py-2 border">{{ $item->konsultan->user->username ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $item->created_at->format('d F Y') }}</td>
                    <td class="px-4 py-2 border">
                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-medium">Selesai</span>
                    </td>
                    <td class="px-4 py-2 border">
                        {{ $item->hasilKonsultasi->ringkasan ?? '-' }}
                    </td>
                    <td class="px-4 py-2 border">
                        {{ $item->hasilKonsultasi->solusi ?? '-' }}
                    </td>
                    <td class="px-4 py-2 border text-center">
                        @if(!empty($item->hasilKonsultasi->dokumen))
                        <a href="{{ asset('storage/' . $item->hasilKonsultasi->dokumen) }}" target="_blank"
                            class="text-emerald-600 hover:underline">Lihat</a>
                        @else
                        <span class="text-gray-400">Tidak ada</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-gray-500 py-4">Belum ada konsultasi yang selesai.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Detail --}}
    {{-- <div x-show="openDetail" x-transition
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4" style="display: none;">
        <div @click.away="openDetail = false"
            class="bg-white rounded-lg shadow-lg w-full max-w-5xl max-h-[90vh] p-6 relative overflow-y-auto">
    
            <h3 class="text-lg font-bold text-emerald-700 mb-4">Detail Konsultasi</h3>
    
            <div class="space-y-2 text-sm text-gray-600">
                <p><strong>Topik:</strong> {{ $permintaan->topik->nama_topik }}</p>
                <p><strong>Konsultan:</strong> {{ $permintaan->konsultan->user->username ?? '-' }}</p>
                <p><strong>Preferensi Tanggal:</strong> {{
                    \Carbon\Carbon::parse($permintaan->preferensi_tanggal)->format('d F Y') }}</p>
                <p><strong>Deskripsi Masalah:</strong> {{ $permintaan->deskripsi_masalah ?? '-' }}</p>
                <p><strong>Status:</strong> {{ ucfirst($permintaan->status) }}</p>
                <p><strong>Dibuat pada:</strong> {{ $permintaan->created_at->format('d F Y H:i') }}</p>
            </div>
    
            <button @click="openDetail = false"
                class="mt-4 px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                Tutup
            </button>
        </div>
    </div> --}}
</div>
@endsection