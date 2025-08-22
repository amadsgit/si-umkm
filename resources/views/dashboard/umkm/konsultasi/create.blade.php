@extends('layouts.dashboard')
@section('title', 'Ajukan Konsultasi')

@section('content')
<div class="max-w-3xl mx-auto px-6">
    <div class="bg-white shadow-xl rounded-3xl p-10 border border-gray-200">
        <h2 class="text-xl font-bold mb-10 text-emerald-500">Ajukan Konsultasi</h2>

        <form action="{{ route('dashboard.umkm.konsultasi.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Pilih Topik --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Topik Konsultasi</label>
                <select name="topik_id"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3"
                    required>
                    <option value="">-- Pilih Topik --</option>
                    @foreach($topikList as $topik)
                    <option value="{{ $topik->id }}" {{ old('topik_id')==$topik->id ? 'selected' : '' }}>
                        {{ $topik->nama_topik }}
                    </option>
                    @endforeach
                </select>
                @error('topik_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tanggal Preferensi --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Tanggal Preferensi</label>
                <input type="date" name="preferensi_tanggal" value="{{ old('preferensi_tanggal') }}"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3"
                    required>
                @error('preferensi_tanggal') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Deskripsi Masalah --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Deskripsi Masalah</label>
                <textarea name="deskripsi_masalah" rows="4"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3">{{ old('deskripsi_masalah') }}</textarea>
                @error('deskripsi_masalah') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end space-x-4">
                <a href="{{ route('dashboard.umkm.konsultasi.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-8 rounded-xl transition duration-200 shadow-md">
                    Batal
                </a>
                <button type="submit"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-8 rounded-xl transition duration-200 shadow-md">
                    Ajukan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection