@extends('layouts.dashboard')
@section('title', 'Tambah Jadwal Pembinaan')

@section('content')
<div class="max-w-4xl mx-auto px-6">
    <div class="bg-white shadow-xl rounded-3xl p-10 border border-gray-200">
        <h2 class="text-xl font-bold mb-10 text-left text-emerald-500">Tambah Jadwal Pembinaan</h2>

        <form action="{{ route('admin.jadwal-pembinaan.store') }}" method="POST" enctype="multipart/form-data"
            class="grid grid-cols-1 gap-6">
            @csrf

            {{-- Jenis Pembinaan --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Jenis Pembinaan</label>
                <select name="jenis_id"
                    class="w-full bg-gray-100 rounded-xl border @error('jenis_id') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                    required>
                    <option value="">-- Pilih Jenis Pembinaan --</option>
                    @foreach($jenisList as $jenis)
                    <option value="{{ $jenis->id }}" {{ old('jenis_id')==$jenis->id ? 'selected' : '' }}>
                        {{ $jenis->nama_pembinaan }}
                    </option>
                    @endforeach
                </select>
                @error('jenis_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Topik Pembinaan --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Topik Pembinaan (Opsional)</label>
                <select name="topik_pembinaan_id"
                    class="w-full bg-gray-100 rounded-xl border @error('topik_pembinaan_id') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                    <option value="">-- Pilih Topik Pembinaan --</option>
                    @foreach($topikList as $topik)
                    <option value="{{ $topik->id }}" {{ old('topik_pembinaan_id')==$topik->id ? 'selected' : '' }}>
                        {{ $topik->nama_topik_pembinaan }}
                    </option>
                    @endforeach
                </select>
                @error('topik_pembinaan_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Judul Jadwal Pembinaan --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Judul Jadwal Pembinaan</label>
                <input type="text" name="judul" value="{{ old('judul') }}"
                    class="w-full bg-gray-100 rounded-xl border @error('judul') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                    required autofocus>
                @error('judul') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                    class="w-full bg-gray-100 rounded-xl border @error('deskripsi') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tanggal --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                    class="w-full bg-gray-100 rounded-xl border @error('tanggal') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                    required>
                @error('tanggal') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Waktu Mulai & Selesai --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Waktu Mulai</label>
                    <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai') }}"
                        class="w-full bg-gray-100 rounded-xl border @error('waktu_mulai') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                        required>
                    @error('waktu_mulai') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Waktu Selesai</label>
                    <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai') }}"
                        class="w-full bg-gray-100 rounded-xl border @error('waktu_selesai') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                        required>
                    @error('waktu_selesai') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Metode --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Metode</label>
                <select name="metode"
                    class="w-full bg-gray-100 rounded-xl border @error('metode') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                    required>
                    <option value="">-- Pilih Metode --</option>
                    <option value="offline" {{ old('metode')=='offline' ? 'selected' : '' }}>Offline</option>
                    <option value="online" {{ old('metode')=='online' ? 'selected' : '' }}>Online</option>
                </select>
                @error('metode') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Lokasi --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Lokasi/Link</label>
                <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                    class="w-full bg-gray-100 rounded-xl border @error('lokasi') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                    required>
                @error('lokasi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Kuota --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Kuota Peserta</label>
                <input type="number" name="kuota" value="{{ old('kuota') }}"
                    class="w-full bg-gray-100 rounded-xl border @error('kuota') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                    required min="1">
                @error('kuota') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Thumbnail --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Thumbnail (Opsional)</label>
                <input type="file" name="thumbnail"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                @error('thumbnail') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('admin.jadwal-pembinaan.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-8 rounded-xl transition duration-200 shadow-md">
                    Batal
                </a>
                <button type="submit"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-8 rounded-xl transition duration-200 shadow-md">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection