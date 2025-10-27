@extends('layouts.dashboard')
@section('title', 'Kegiatan Pembinaan Saya')

@section('content')
<div class="p-6 space-y-8">
    {{-- Navbar --}}
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

    <h1 class="text-2xl font-bold text-emerald-700 mb-4">
        📚 Kegiatan Pembinaan Saya
    </h1>

    <div class="overflow-x-auto">
        <table class="min-w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-3 py-2 border">No</th>
                    <th class="px-3 py-2 border">Judul</th>
                    <th class="px-3 py-2 border">Deskripsi</th>
                    <th class="px-3 py-2 border">Jadwal</th>
                    <th class="px-3 py-2 border">Lokasi</th>
                    <th class="px-3 py-2 border">Absensi Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembinaanSaya as $item)
                @php
                // raw values
                $tanggalRaw = $item->pembinaan->tanggal ?? null;
                $mulaiRaw = $item->pembinaan->waktu_mulai ?? null;
                $selesaiRaw = $item->pembinaan->waktu_selesai ?? null;
            
                // parse tanggal aman (tangkap kemungkinan format aneh)
                $tanggal = null;
                if ($tanggalRaw) {
                try {
                $tanggal = \Carbon\Carbon::parse($tanggalRaw);
                } catch (\Exception $e) {
                if (preg_match('/\d{4}-\d{2}-\d{2}/', $tanggalRaw, $m)) {
                try {
                $tanggal = \Carbon\Carbon::parse($m[0]);
                } catch (\Exception $e2) {
                $tanggal = null;
                }
                }
                }
                }
            
                // ambil komponen waktu dari waktu_mulai / waktu_selesai
                $mulaiHour = $mulaiMinute = $mulaiSecond = 0;
                $selesaiHour = $selesaiMinute = $selesaiSecond = 0;
            
                if ($mulaiRaw) {
                try {
                $tmp = \Carbon\Carbon::parse($mulaiRaw);
                $mulaiHour = (int) $tmp->format('H');
                $mulaiMinute = (int) $tmp->format('i');
                $mulaiSecond = (int) $tmp->format('s');
                } catch (\Exception $e) {
                // leave as 0
                }
                }
            
                if ($selesaiRaw) {
                try {
                $tmp2 = \Carbon\Carbon::parse($selesaiRaw);
                $selesaiHour = (int) $tmp2->format('H');
                $selesaiMinute = (int) $tmp2->format('i');
                $selesaiSecond = (int) $tmp2->format('s');
                } catch (\Exception $e) {
                // leave as 0
                }
                }
            
                // gabungkan tanggal + jam (tanpa concat string)
                $waktuMulai = ($tanggal && $mulaiRaw)
                ? $tanggal->copy()->setTime($mulaiHour, $mulaiMinute, $mulaiSecond)
                : null;
            
                $waktuSelesai = ($tanggal && $selesaiRaw)
                ? $tanggal->copy()->setTime($selesaiHour, $selesaiMinute, $selesaiSecond)
                : null;
            
                $now = now();
                @endphp
            
                <tr>
                    <td class="border px-3 py-2 text-center">{{ $pembinaanSaya->firstItem() + $loop->index }}</td>
                    <td class="border px-3 py-2 font-semibold">
                        {{ $item->pembinaan->judul ?? '-' }} <br>

                        @php
                        $feedbackPembinaan = \App\Models\Feedback::where('umkm_id', Auth::user()->umkm->id)
                        ->where('target_id', $item->id)
                        ->where('target_type', 'pembinaan')
                        ->first();
                        @endphp
                        
                        @if($feedbackPembinaan)
                        <div class="mt-1 inline-flex items-center space-x-1">
                            @for($i = 1; $i <= 5; $i++) @if($i <=$feedbackPembinaan->rating)
                                <i class="ph ph-star text-yellow-400 text-lg font-bold"></i>
                                @else
                                <i class="ph ph-star text-gray-300 text-lg"></i>
                                @endif
                                @endfor
                        </div>
                        @elseif($waktuSelesai && $now->gt($waktuSelesai))
                        {{-- tombol beri feedback hanya muncul kalau pembinaan sudah selesai --}}
                        <a href="{{ route('dashboard.umkm.pembinaan.feedback', $item->id) }}"
                            class="mt-1 inline-block px-3 py-1 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                            Beri Feedback
                        </a>
                        @endif
                    </td>
                    <td class="border px-3 py-2">
                        {{ \Illuminate\Support\Str::limit($item->pembinaan->deskripsi, 50) ?? '-' }}
                    </td>
                    <td class="border font-bold px-3 py-2">
                        {{-- Tanggal --}}
                        {{ $tanggal ? $tanggal->translatedFormat('d M Y') : '-' }} <br>
            
                        {{-- Jam tampil --}}
                        @if($mulaiRaw && $selesaiRaw)
                        {{ \Carbon\Carbon::parse($mulaiRaw)->format('H.i') }} - {{ \Carbon\Carbon::parse($selesaiRaw)->format('H.i')
                        }}
                        @elseif($mulaiRaw)
                        {{ \Carbon\Carbon::parse($mulaiRaw)->format('H.i') }} -
                        @else
                        -
                        @endif
            
                        {{-- Countdown / status --}}
                        @if($waktuMulai)
                        @if($now->lt($waktuMulai))
                        <span class="text-sm text-emerald-600">
                            ({{ $now->diffForHumans($waktuMulai, ['parts' => 2, 'join' => true]) }})
                        </span>
                        @elseif($waktuSelesai && $now->between($waktuMulai, $waktuSelesai))
                        <span class="text-sm text-yellow-500">(Sedang berlangsung)</span>
                        @else
                        <span class="text-sm text-red-500">(Selesai)</span>
                        @endif
                        @endif
                    </td>
                    <td class="border px-3 py-2">
                        {{ $item->pembinaan->lokasi ?? '-' }}
                    </td>
                    <td class="border px-3 py-2 text-center">
                        @if($waktuMulai && $now->lt($waktuMulai))
                        <span class="text-gray-500 text-sm">Absen belum dibuka</span>
                        @elseif($waktuMulai && $waktuSelesai && $now->between($waktuMulai, $waktuSelesai) && $item->status_kehadiran ===
                        'belum_absensi')
                        {{-- Tombol buka modal --}}
                        <button data-id="{{ $item->id }}"
                            class="btn-absen bg-blue-500 text-white px-2 py-1 rounded text-xs hover:bg-blue-600">
                            Absen
                        </button>
                        @else
                        <span class="px-2 py-1 rounded text-xs
                                @if($item->status_kehadiran == 'hadir') bg-green-100 text-green-700
                                @elseif($item->status_kehadiran == 'izin') bg-yellow-100 text-yellow-700
                                @elseif($item->status_kehadiran == 'tidak_hadir') bg-red-100 text-red-700
                                @else bg-gray-100 text-gray-700 @endif">
                            {{ ucfirst(str_replace('_',' ',$item->status_kehadiran)) }}
                        </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 py-3">Belum ada kegiatan pembinaan yang diikuti.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4 mb-4">
            {{ $pembinaanSaya->links('vendor.pagination.tailwind') }}
        </div>
    </div>


    <!-- Modal Absensi -->
    <div id="absenModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-bold mb-4">Pilih Status Kehadiran</h2>
            <form id="absenForm" method="POST">
                @csrf
                <div class="space-y-3">
                    <button type="submit" name="status_kehadiran" value="hadir"
                        class="w-full py-2 bg-green-500 text-white rounded hover:bg-green-600">
                        Hadir
                    </button>
                    <button type="submit" name="status_kehadiran" value="izin"
                        class="w-full py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                        Izin
                    </button>
                </div>
                <button type="button" id="closeModal"
                    class="mt-4 w-full py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                    Batal
                </button>
            </form>
        </div>
    </div>
    
    <script>
        document.querySelectorAll('.btn-absen').forEach(btn => {
        btn.addEventListener('click', function() {
            let id = this.dataset.id;
            let form = document.getElementById('absenForm');
            form.action = "/dashboard/umkm/pembinaan/absen/" + id;
            document.getElementById('absenModal').classList.remove('hidden');
        });
    });
    
    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('absenModal').classList.add('hidden');
    });
    </script>
</div>
@endsection