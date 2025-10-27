@extends('layouts.dashboard')
@section('title', 'Dashboard Konsultan')

@section('content')
<div class="p-6 space-y-8">

    {{-- Header --}}
    @if($jadwalBerlangsung)
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-xl shadow">
        <h2 class="text-lg font-bold text-yellow-700 mb-2">
            📅 Jadwal Konsultasi Sedang Berlangsung
        </h2>
        <p><strong>UMKM:</strong> {{ $jadwalBerlangsung->umkm->user->username }}</p>
        <p><strong>Topik:</strong> {{ $jadwalBerlangsung->topik->nama_topik }}</p>
        <p><strong>Waktu:</strong>
            {{ \Carbon\Carbon::parse($jadwalBerlangsung->jadwal->waktu_mulai)->format('H:i') }} -
            {{ \Carbon\Carbon::parse($jadwalBerlangsung->jadwal->waktu_selesai)->format('H:i') }} WIB
        </p>
        <p class="mt-2 text-sm text-gray-600">
            ⏳ Sisa waktu: <span id="countdown"></span> 
        </p>
    </div>
    
    <script>
        const endTime = new Date("{{ \Carbon\Carbon::parse($jadwalBerlangsung->jadwal->tanggal . ' ' . $jadwalBerlangsung->jadwal->waktu_selesai) }}").getTime();
            const countdownEl = document.getElementById('countdown');
    
            function updateCountdown() {
                const now = new Date().getTime();
                const distance = endTime - now;
    
                if (distance <= 0) {
                    countdownEl.innerHTML = "Selesai";
                    return;
                }
    
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
                countdownEl.innerHTML = `${hours}j ${minutes}m ${seconds}d`;
            }
    
            updateCountdown();
            setInterval(updateCountdown, 1000);
    </script>
    @endif

    {{-- tabel konsultasi dijadwalkan --}}
    <section>
        <h2 class="text-xl font-bold text-emerald-600 mb-4">Konsultasi Dijadwalkan</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border text-sm">
                <thead class="bg-emerald-500 text-white">
                    <tr>
                        <th class="px-3 py-2 border">No</th>
                        <th class="px-3 py-2 border">UMKM</th>
                        <th class="px-3 py-2 border">Topik</th>
                        <th class="px-3 py-2 border">Konsultan</th>
                        <th class="px-3 py-2 border">Jadwal Kegiatan</th>
                        <th class="px-3 py-2 border">Link/Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($konsultasiDijadwalkan as $item)
                    <tr>
                        <td class="border px-3 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-3 py-2">{{ $item->umkm->nama_usaha }}</td>
                        <td class="border px-3 py-2">{{ $item->topik->nama_topik }}</td>
                        <td class="border px-3 py-2">{{ $item->konsultan->user->username ?? '-' }}</td>
                        <td class="border font-bold px-3 py-2">
                            @if($item->jadwal)
                            {{-- Format tanggal --}}
                            {{ \Carbon\Carbon::parse($item->jadwal->tanggal)->format('d M Y') }}
    
                            {{-- Format jam tanpa detik --}}
                            {{ \Carbon\Carbon::parse($item->jadwal->waktu_mulai)->format('H.i') }} -
                            {{ \Carbon\Carbon::parse($item->jadwal->waktu_selesai)->format('H.i') }}
    
                            {{-- Countdown --}}
                            @php
                            $waktuMulai = \Carbon\Carbon::parse($item->jadwal->tanggal . ' ' . $item->jadwal->waktu_mulai);
                            $now = now();
                            @endphp
    
                            @if($now->lessThan($waktuMulai))
                            <span class="text-sm text-emerald-600">
                                ({{ $now->diffForHumans($waktuMulai, [
                                'parts' => 2,
                                'join' => true
                                ]) }})
                            </span>
                            @else
                            <span class="text-sm text-red-500">(Sedang berlangsung / Selesai)</span>
                            @endif
                            @else
                            <span class="text-gray-500">Belum dijadwalkan</span>
                            @endif
                        </td>
                        <td class="border px-3 py-2">
                            @if($item->jadwal)
                            {{ ucfirst($item->jadwal->metode) }}<br>
    
                            @if(Str::startsWith($item->jadwal->lokasi_link, ['http://', 'https://']))
                            {{-- Link Online --}}
                            <a href="{{ $item->jadwal->lokasi_link }}" target="_blank" class="text-blue-600 underline">
                                {{ $item->jadwal->lokasi_link }}
                            </a>
                            @else
                            {{-- Alamat Offline --}}
                            <span class="text-gray-800">{{ $item->jadwal->lokasi_link }}</span>
                            @endif
    
                            @else
                            <span class="text-gray-500">Belum ada lokasi/link</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-3">Tidak ada permintaan dijadwalkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4 mb-4">
                {{ $konsultasiDijadwalkan->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </section>

    {{-- tabel konsultasi selesai --}}
    <section>
        <h2 class="text-xl font-bold text-blue-600 mb-4">Riwayat Konsultasi Selesai</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border text-sm">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="px-3 py-2 border">No</th>
                        <th class="px-3 py-2 border">UMKM</th>
                        <th class="px-3 py-2 border">Topik</th>
                        {{-- <th class="px-3 py-2 border">Konsultan</th> --}}
                        <th class="px-3 py-2 border">Jadwal Kegiatan</th>
                        <th class="px-3 py-2 border">Link/Lokasi</th>
                        <th class="px-3 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($konsultasiSelesai as $item)
                    <tr>
                        <td class="px-4 py-2 border">{{ $konsultasiSelesai->firstItem() + $loop->index }}</td>
                        <td class="border px-3 py-2">{{ $item->umkm->nama_usaha }}</td>
                        <td class="border px-3 py-2">{{ $item->topik->nama_topik }}</td>
                        {{-- <td class="border px-3 py-2">{{ $item->konsultan->user->username ?? '-' }}</td> --}}
                        <td class="border font-bold px-3 py-2">
                            @if($item->jadwal)
                            {{-- Format tanggal --}}
                            {{ \Carbon\Carbon::parse($item->jadwal->tanggal)->format('d M Y') }}
    
                            {{-- Format jam tanpa detik --}}
                            {{ \Carbon\Carbon::parse($item->jadwal->waktu_mulai)->format('H.i') }} -
                            {{ \Carbon\Carbon::parse($item->jadwal->waktu_selesai)->format('H.i') }}
    
                            {{-- Countdown --}}
                            @php
                            $waktuMulai = \Carbon\Carbon::parse($item->jadwal->tanggal . ' ' . $item->jadwal->waktu_mulai);
                            $now = now();
                            @endphp
    
                            @if($now->lessThan($waktuMulai))
                            <span class="text-sm text-emerald-600">
                                ({{ $now->diffForHumans($waktuMulai, [
                                'parts' => 2,
                                'join' => true
                                ]) }})
                            </span>
                            @else
                            <span class="text-sm text-red-500">(Selesai)</span>
                            @endif
                            @else
                            <span class="text-gray-500">Belum dijadwalkan</span>
                            @endif
                        </td>
                        <td class="border px-3 py-2">
                            @if($item->jadwal)
                            {{ ucfirst($item->jadwal->metode) }}<br>
    
                            @if(Str::startsWith($item->jadwal->lokasi_link, ['http://', 'https://']))
                            {{-- Link Online --}}
                            <a href="{{ $item->jadwal->lokasi_link }}" target="_blank" class="text-blue-600 underline">
                                {{ $item->jadwal->lokasi_link }}
                            </a>
                            @else
                            {{-- Alamat Offline --}}
                            <span class="text-gray-800">{{ $item->jadwal->lokasi_link }}</span>
                            @endif
    
                            @else
                            <span class="text-gray-500">Belum ada lokasi/link</span>
                            @endif
                        </td>
                        <td class="border px-3 py-2">
                            @if($item->jadwal && $item->jadwal->hasilKonsultasi)
                            <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-xs flex items-center gap-1"
                                @click="lihatHasil({{ $item->jadwal->hasilKonsultasi->toJson() }})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Lihat Hasil Konsultasi
                            </button>
                            @else
                            <a href="{{ route('konsultan.hasil-konsultasi.form', $item->jadwal->id) }}">
                                <button
                                    class="bg-yellow-500 text-white px-3 py-1 rounded text-xs font-semibold shadow-md hover:bg-yellow-600 animate-pulse flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z" />
                                    </svg>
                                    Isi Hasil Konsultasi
                                </button>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-3">Tidak ada permintaan dijadwalkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4 mb-4">
                {{ $konsultasiSelesai->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </section>

    <div x-data="{ open: false, hasil: {} }" @lihat-hasil.window="open = true; hasil = $event.detail">
        <template x-if="open">
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                <div class="bg-white p-6 rounded shadow-lg w-full max-w-5xl max-h-[90vh] overflow-y-auto">
                    <h3 class="text-lg text-emerald-500 font-bold mb-2">Hasil Konsultasi</h3>
    
                    <p class="mb-1 font-semibold">Ringkasan:</p>
                    <p class="text-gray-700 mb-4" x-text="hasil.ringkasan"></p>
    
                    <p class="mb-1 font-semibold">Solusi:</p>
                    <p class="text-gray-700 mb-4" x-text="hasil.solusi"></p>
    
                    <template x-if="hasil.dokumen_url">
                        <div class="mb-4">
                            <h4 class="font-semibold">Lampiran:</h4>
                            <a :href="hasil.dokumen_url" target="_blank" class="text-blue-600 underline">
                                📄 Lihat Dokumen
                            </a>
                        </div>
                    </template>
    
                    <div class="text-right">
                        <button @click="open = false"
                            class="bg-white border border-gray-600 hover:bg-gray-100 px-4 py-2 rounded">Tutup</button>
                    </div>
                </div>
            </div>
        </template>
    </div>
    
    <script>
        function lihatHasil(data) {
            // pastikan data berisi dokumen_url
            window.dispatchEvent(new CustomEvent('lihat-hasil', { detail: data }));
        }
    </script>

</div>
@endsection