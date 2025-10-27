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

    {{-- Permintaan Selesai --}}
    <h2 class="text-lg font-semibold text-gray-700 mt-8">Riwayat Konsultasi Selesai</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg mt-2">
            <thead class="bg-blue-500 text-white text-sm">
                <tr>
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Topik</th>
                    <th class="px-4 py-2 border">Konsultan</th>
                    <th class="px-4 py-2 border">Tanggal Konsultasi</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Ringkasan</th>
                    <th class="px-4 py-2 border">Solusi</th>
                    <th class="px-4 py-2 border">Lampiran</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($riwayatList as $item)
                <tr class="hover:bg-gray-50 align-top">
                    <td class="px-4 py-2 border">{{ $riwayatList->firstItem() + $loop->index }}</td>
                    <td class="px-4 py-2 border">{{ $item->topik->nama_topik }}</td>
                    <td class="px-4 py-2 border"> 
                        {{ $item->konsultan->user->username ?? '-' }}
                    
                        @php
                        $feedback = \App\Models\Feedback::where('umkm_id', $user->umkm->id)
                        ->where('target_id', $item->id)
                        ->where('target_type', 'konsultan')
                        ->first();
                        @endphp
                        
                        @if(!$feedback && (!empty($item->hasilKonsultasi->ringkasan) || !empty($item->hasilKonsultasi->solusi)))
                        <a href="{{ route('dashboard.umkm.konsultasi.feedback', $item->id) }}"
                            class="ml-2 inline-block px-3 py-1 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                            Beri Feedback
                        </a>
                        @elseif($feedback)
                        <div class="ml-2 inline-flex items-center space-x-1">
                            @for($i = 1; $i <= 5; $i++) @if($i <=$feedback->rating)
                                <i class="ph ph-star text-yellow-400 text-lg font-bold"></i>
                                @else
                                <i class="ph ph-star text-gray-300 text-lg"></i>
                                @endif
                                @endfor
                        </div>
                        @endif
                    </td>
                    <td class="px-4 py-2 border">
                        {{ optional($item->jadwal)->tanggal
                        ? \Carbon\Carbon::parse($item->jadwal->tanggal)->translatedFormat('d F Y')
                        : '-' }}
                    </td>
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
        <div class="mt-4 mb-4">
            {{ $riwayatList->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    {{-- Permintaan Ditolak --}}
    <h2 class="text-lg font-semibold text-gray-700 mt-8 mb-4">Permintaan Ditolak</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg mt-2">
            <thead class="bg-rose-500 text-white text-sm text-sm">
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
</div>
@endsection