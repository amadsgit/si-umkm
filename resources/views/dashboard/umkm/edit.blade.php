@extends('layouts.dashboard')
@section('title', 'Edit Profil UMKM')

@section('content')
<div class="max-w-5xl mx-auto px-6">
    <div class="bg-white shadow-xl rounded-3xl p-10 border border-gray-200">
        <h1 class="text-2xl font-bold mb-8 text-emerald-500">Edit Profil UMKM</h1>

        {{-- Alert jika ada error --}}
        @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-xl border border-red-300">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Form Edit --}}
        <form action="{{ route('dashboard.umkm.update', $umkm->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Nama Usaha --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Usaha</label>
                <input type="text" name="nama_usaha" value="{{ old('nama_usaha', $umkm->nama_usaha) }}"
                    class="w-full bg-gray-100 rounded-xl border @error('nama_usaha') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                @error('nama_usaha') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Bidang Usaha --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Bidang Usaha</label>
                <input type="text" name="bidang_usaha" value="{{ old('bidang_usaha', $umkm->bidang_usaha) }}"
                    class="w-full bg-gray-100 rounded-xl border @error('bidang_usaha') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                @error('bidang_usaha') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Alamat Usaha --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Alamat Usaha</label>
                <textarea name="alamat_usaha" rows="3"
                    class="w-full bg-gray-100 rounded-xl border @error('alamat_usaha') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">{{ old('alamat_usaha', $umkm->alamat_usaha) }}</textarea>
                @error('alamat_usaha') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tahun Berdiri & Kategori Usaha --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Tahun Berdiri</label>
                    <input type="number" name="tahun_berdiri" value="{{ old('tahun_berdiri', $umkm->tahun_berdiri) }}"
                        class="w-full bg-gray-100 rounded-xl border @error('tahun_berdiri') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                    @error('tahun_berdiri') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Kategori Usaha</label>
                    <input type="text" name="kategori_usaha" value="{{ old('kategori_usaha', $umkm->kategori_usaha) }}"
                        class="w-full bg-gray-100 rounded-xl border @error('kategori_usaha') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                    @error('kategori_usaha') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Foto Profil --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Foto Profil</label>
                <input type="file" name="foto_profil"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-2 transition">
                @error('foto_profil') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror

                @if ($umkm->foto_profil)
                <div class="mt-3 flex items-center space-x-4">
                    <img src="{{ asset('storage/' . $umkm->foto_profil) }}" alt="Foto UMKM"
                        class="w-24 h-24 object-cover rounded-xl shadow-md">
                    <p class="text-xs text-gray-500">Foto lama akan dihapus otomatis jika mengunggah foto baru</p>
                </div>
                @endif
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('dashboard.umkm.profil') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-8 rounded-xl transition duration-200 shadow-md">
                    Batal
                </a>
                <button type="submit"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-8 rounded-xl transition duration-200 shadow-md">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection