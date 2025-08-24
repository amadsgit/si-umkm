@extends('layouts.dashboard')
@section('title', 'Dashboard Kepala UPTD')

@section('content')
<div class="p-6 space-y-8">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-emerald-500 to-green-600 rounded-2xl shadow-lg p-8 text-white">
        <h6 class="text-3xl font-bold mb-2">
            Selamat datang, {{ $user->username }} 👋
        </h6>
        <p class="text-sm text-emerald-100">Pantau statistik pembinaan dan konsultasi dengan mudah.</p>
    </div>

    {{-- Statistik Box --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col items-center">
            <p class="text-gray-500 text-sm mb-2">Total Pembinaan</p>
            <h3 class="text-3xl font-bold text-emerald-600">{{ array_sum($pembinaanData) }}</h3>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col items-center">
            <p class="text-gray-500 text-sm mb-2">Total Konsultasi</p>
            <h3 class="text-3xl font-bold text-blue-600">{{ array_sum($konsultasiData) }}</h3>
        </div>
        @php
        $label = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        @endphp
        
        <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col items-center">
            <p class="text-gray-500 text-sm mb-2">Bulan dengan Pembinaan Tertinggi</p>
            <h3 class="text-lg font-semibold text-emerald-700">
                {{ $label[collect($pembinaanData)->search(max($pembinaanData))] ?? '-' }}
            </h3>
        </div>
        
        <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col items-center">
            <p class="text-gray-500 text-sm mb-2">Bulan dengan Konsultasi Tertinggi</p>
            <h3 class="text-lg font-semibold text-blue-700">
                {{ $label[collect($konsultasiData)->search(max($konsultasiData))] ?? '-' }}
            </h3>
        </div>
    </div>

    {{-- Grafik --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Grafik Batang --}}
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Statistik Bulanan</h2>
            <canvas id="barChart" height="150"></canvas>
        </div>

        {{-- Grafik Pie --}}
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Perbandingan Total</h2>
            <canvas id="pieChart" height="150"></canvas>
        </div>
    </div>

    {{-- Info Akun --}}
    <div class="bg-white rounded-2xl shadow-md p-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-6">Informasi Akun</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-6 text-gray-700">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Telepon:</strong> {{ $user->phone ?? '-' }}</p>
            <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
            <p><strong>Terakhir Login:</strong> {{ $user->last_login ?? '-' }}</p>
        </div>
    </div>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($labels);
    const pembinaanData = @json($pembinaanData);
    const konsultasiData = @json($konsultasiData);

    // Grafik Batang
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pembinaan',
                    data: pembinaanData,
                    backgroundColor: 'rgba(16, 185, 129, 0.7)',
                    borderRadius: 8,
                },
                {
                    label: 'Konsultasi',
                    data: konsultasiData,
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderRadius: 8,
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Grafik Pie
    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: ['Pembinaan', 'Konsultasi'],
            datasets: [{
                data: [pembinaanData.reduce((a, b) => a + b, 0), konsultasiData.reduce((a, b) => a + b, 0)],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
        }
    });
</script>
@endsection