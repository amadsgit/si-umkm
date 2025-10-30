@extends('layouts.dashboard')
@section('title', 'Dashboard Admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-lg space-y-8">

    <!-- Header Selamat Datang -->
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-800">Selamat Datang, {{ $user->username }} 👋</h1>
            <p class="text-sm text-gray-500 mt-1">
                Anda sedang masuk sebagai
                <span class="font-medium text-emerald-600">{{ ucfirst($user->role) }}</span>.
            </p>
        </div>
        <div class="flex-shrink-0">
            <img src="{{ Auth::user()->umkm && Auth::user()->umkm->foto_profil
                ? asset('storage/' . Auth::user()->umkm->foto_profil)
                : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->username) . '&background=10B981&color=fff' }}"
                alt="Avatar" class="w-12 h-12 rounded-full border-2 border-white shadow-md object-cover">
        </div>
    </div>

    <!-- Statistik Ringkas -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
        <div
            class="bg-gradient-to-br from-emerald-50 to-white border border-emerald-200 rounded-xl p-5 shadow hover:shadow-lg transition">
            <div class="flex justify-between items-center">
                <h3 class="text-emerald-700 font-semibold">Total UMKM</h3>
                <!-- simple store icon -->
                <svg class="w-5 h-5 text-emerald-600" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 9.5L12 4l9 5.5V20a1 1 0 0 1-1 1h-6v-6H10v6H4a1 1 0 0 1-1-1V9.5z" stroke="currentColor"
                        stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <p class="text-3xl font-bold text-emerald-800 mt-2">{{ $umkm->count() }}</p>
        </div>

        <div
            class="bg-gradient-to-br from-sky-50 to-white border border-sky-200 rounded-xl p-5 shadow hover:shadow-lg transition">
            <div class="flex justify-between items-center">
                <h3 class="text-sky-700 font-semibold">Total Konsultan</h3>
                <!-- user-check icon -->
                <svg class="w-5 h-5 text-sky-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 11a4 4 0 1 0-8 0" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M12 14v6" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M19 21l-3-3" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
            <p class="text-3xl font-bold text-sky-800 mt-2">{{ $konsultan->count() }}</p>
        </div>

        <div
            class="bg-gradient-to-br from-amber-50 to-white border border-amber-200 rounded-xl p-5 shadow hover:shadow-lg transition">
            <div class="flex justify-between items-center">
                <h3 class="text-amber-700 font-semibold">Jadwal Pembinaan</h3>
                <!-- calendar-days icon -->
                <svg class="w-5 h-5 text-amber-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.2" />
                    <path d="M16 3v4M8 3v4M3 11h18" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" />
                </svg>
            </div>
            <p class="text-3xl font-bold text-amber-800 mt-2">{{ $pembinaan->count() }}</p>
        </div>

        <div
            class="bg-gradient-to-br from-rose-50 to-white border border-rose-200 rounded-xl p-5 shadow hover:shadow-lg transition">
            <div class="flex justify-between items-center">
                <h3 class="text-rose-700 font-semibold">Jadwal Konsultasi</h3>
                <!-- message-circle icon -->
                <svg class="w-5 h-5 text-rose-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 12a9 9 0 1 1-3.5-7.1L21 3v9z" stroke="currentColor" stroke-width="1.2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <p class="text-3xl font-bold text-rose-800 mt-2">{{ $konsultasi->count() }}</p>
        </div>
    </div>

    <!-- Grafik Statistik -->
    <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 mt-8 shadow-inner">
        <h2 class="text-xl font-bold text-gray-700 mb-4">Grafik Aktivitas Bulanan</h2>
        <canvas id="chartKegiatan" height="100"></canvas>
    </div>

    <!-- Daftar Jadwal Terbaru -->
    <div class="grid lg:grid-cols-2 gap-6 mt-8">
    
        <!-- Jadwal Pembinaan -->
        <div
            class="bg-gradient-to-br from-emerald-50 to-white rounded-2xl p-6 shadow-lg border border-emerald-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <h3 class="text-lg font-semibold text-emerald-700 mb-4 flex items-center gap-2">
                <!-- calendar icon -->
                <svg class="w-5 h-5 text-emerald-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.4" />
                    <path d="M16 2v4M8 2v4M3 10h18" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" />
                </svg>
                Jadwal Pembinaan Terbaru
            </h3>
    
            <div class="divide-y divide-emerald-100/70 max-h-80 overflow-y-auto">
                @forelse($pembinaan->take(5) as $p)
                <div class="py-3 hover:bg-emerald-50/60 rounded-lg px-2 transition-colors">
                    <p class="font-medium text-gray-800">{{ $p->topik->nama_topik_pembinaan ?? '-' }}</p>
                    <p class="text-sm text-gray-500 flex items-center gap-1">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d F Y') }}
                        • <span class="text-emerald-600 font-medium">{{ $p->jenis->nama_pembinaan ?? 'Umum' }}</span>
                    </p>
                </div>
                @empty
                <p class="text-sm text-gray-500 italic py-3 px-2">Belum ada jadwal pembinaan.</p>
                @endforelse
            </div>
        </div>
    
        <!-- Jadwal Konsultasi -->
        <div
            class="bg-gradient-to-br from-sky-50 to-white rounded-2xl p-6 shadow-lg border border-sky-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <h3 class="text-lg font-semibold text-sky-700 mb-4 flex items-center gap-2">
                <!-- message icon -->
                <svg class="w-5 h-5 text-sky-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 12a9 9 0 1 1-3.5-7.1L21 3v9z" stroke="currentColor" stroke-width="1.4"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Jadwal Konsultasi Terbaru
            </h3>
    
            <div class="divide-y divide-sky-100/70 max-h-80 overflow-y-auto">
                @forelse($konsultasi->take(5) as $k)
                <div class="py-3 hover:bg-sky-50/60 rounded-lg px-2 transition-colors">
                    <p class="font-medium text-gray-800">UMKM: {{ $k->permintaan->umkm->nama_usaha ?? '-' }}</p>
                    <p class="text-sm text-gray-500 flex items-center gap-1">
                        <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ \Carbon\Carbon::parse($k->tanggal)->translatedFormat('d F Y') }}
                        • <span class="text-sky-600 font-medium">{{ ucfirst($k->permintaan->status ?? '-') }}</span>
                    </p>
                </div>
                @empty
                <p class="text-sm text-gray-500 italic py-3 px-2">Belum ada jadwal konsultasi.</p>
                @endforelse
            </div>
        </div>
    
    </div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('chartKegiatan').getContext('2d');

    // Labels statis untuk bulan 
    const labels = {!! json_encode(['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des']) !!};

    // Data dari controller 
    const pembinaanData = {!! json_encode($pembinaanData) !!};
    const konsultasiData = {!! json_encode($konsultasiData) !!};

    new Chart(ctx, {
        type: 'line',
        data: {
        labels: labels,
        datasets: [
            {
                label: 'Pembinaan',
                data: pembinaanData,
                borderColor: '#10B981', // emerald-500
                backgroundColor: 'rgba(16, 185, 129, 0.15)', // emerald-500 transparent
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#059669', // emerald-600
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#059669',
                pointHoverBorderColor: '#fff',
            },
            {
                label: 'Konsultasi',
                data: konsultasiData,
                borderColor: '#0EA5E9', // sky-500
                backgroundColor: 'rgba(14, 165, 233, 0.15)', // sky-500 transparent
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#0284C7', // sky-600
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#0284C7',
                pointHoverBorderColor: '#fff',
            }
        ] },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top', labels: { font: { size: 12 } } },
                tooltip: { mode: 'index', intersect: false }
            },
            interaction: { mode: 'index', intersect: false },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
            }
        }
    });
});
</script>
@endpush
@endsection