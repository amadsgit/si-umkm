@extends('layouts.dashboard')
@section('title', 'Dashboard Admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-lg space-y-6">

    <!-- Header Selamat Datang -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-800">Selamat Datang, {{ $user->username }} 👋
            </h1>
            <p class="text-sm text-gray-500 mt-1">Anda sedang masuk sebagai <span
                    class="font-medium text-emerald-600">{{ ucfirst($user->role) }}</span>.</p>
        </div>
        <div class="hidden md:block">
            <img src="{{ Auth::user()->umkm && Auth::user()->umkm->foto_profil
                                        ? asset('storage/' . Auth::user()->umkm->foto_profil)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->username) . '&background=10B981&color=fff' }}"
                alt="Avatar" class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-md">
        </div>
    </div>

    <!-- Card Info Akun -->
    <div class="grid md:grid-cols-2 gap-6 mt-6">
        <div
            class="bg-emerald-50 border border-emerald-200 rounded-lg p-5 shadow-sm">
            <h2 class="text-xl font-semibold text-emerald-800 mb-3">Informasi Akun</h2>
            <ul class="text-sm text-gray-700 space-y-2">
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Telepon:</strong> {{ $user->phone ?? '-' }}</li>
                <li><strong>Role:</strong> {{ ucfirst($user->role) }}</li>
                <li><strong>Terakhir login:</strong> {{ $user->last_login ?
                    \Carbon\Carbon::parse($user->last_login)->translatedFormat('d F Y H:i') : '-' }}</li>
            </ul>
        </div>

        <!-- Statistik Placeholder (opsional) -->
        <div class="bg-sky-50 border border-sky-200 rounded-lg p-5 shadow-sm">
            <h2 class="text-xl font-semibold text-sky-800 mb-3">Aktivitas Sistem</h2>
            <p class="text-sm text-gray-600">Tidak ada notifikasi baru saat ini. Silakan periksa data
                pengguna atau pengelolaan konten.</p>
        </div>
    </div>

</div>
@endsection