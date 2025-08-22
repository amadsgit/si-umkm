@extends('layouts.dashboard')
@section('title', 'Edit Jenis Pembinaan')

@section('content')
<div class="max-w-3xl mx-auto px-6">
    <div class="bg-white shadow-xl rounded-3xl p-10 border border-gray-200">
        <h2 class="text-xl font-bold mb-10 text-left text-emerald-500">Edit Jenis Pembinaan</h2>

        <form action="{{ route('admin.jenis-pembinaan.update', $jenis->id) }}" method="POST"
            class="grid grid-cols-1 gap-6">
            @csrf
            @method('PUT')

            {{-- Nama jenis --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Jenis</label>
                <input type="text" name="nama_pembinaan" value="{{ old('nama_pembinaan', $jenis->nama_pembinaan) }}"
                    class="w-full bg-gray-100 rounded-xl border @error('nama_pembinaan') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                    required>
                @error('nama_pembinaan') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                    class="w-full bg-gray-100 rounded-xl border @error('deskripsi') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                    required>{{ old('deskripsi', $jenis->deskripsi) }}</textarea>
                @error('deskripsi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('admin.jenis-pembinaan.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-8 rounded-xl transition duration-200 shadow-md">
                    Batal
                </a>
                <button type="submit"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-8 rounded-xl transition duration-200 shadow-md">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection