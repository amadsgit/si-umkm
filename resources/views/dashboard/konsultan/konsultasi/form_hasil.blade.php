@extends('layouts.dashboard')
@section('title', 'Input Hasil Konsultasi')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4 text-emerald-600">Input Hasil Konsultasi</h2>

    <div class="mb-4 text-sm text-gray-700">
        <p><strong>UMKM:</strong> {{ $jadwal->permintaan->umkm->nama_usaha }}</p>
        <p><strong>Topik:</strong> {{ $jadwal->permintaan->topik->nama_topik }}</p>
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}</p>
        <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} - {{
            \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}</p>
    </div>

    <form action="{{ route('konsultan.hasil-konsultasi.simpan', $jadwal->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1">Ringkasan <span class="text-red-500">*</span></label>
            <textarea name="ringkasan" rows="4" class="w-full border rounded p-2"
                required>{{ old('ringkasan') }}</textarea>
            @error('ringkasan') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Solusi <span class="text-red-500">*</span></label>
            <textarea name="solusi" rows="4" class="w-full border rounded p-2" required>{{ old('solusi') }}</textarea>
            @error('solusi') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Dokumen Pendukung</label>
            <input type="file" name="dokumen" class="w-full border rounded p-2">
            <p class="text-xs text-gray-500 mt-1">(max 2MB per file).</p>
            @error('dokumen.*') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('dashboard.konsultan.konsultasi.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection