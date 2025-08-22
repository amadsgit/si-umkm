@extends('layouts.dashboard')
@section('title', 'Tambah Data Konsultan')

@section('content')
<div class="max-w-4xl mx-auto px-6">
    <div class="bg-white shadow-xl rounded-3xl p-10 border border-gray-200">
        <h2 class="text-xl font-bold mb-10 text-left text-emerald-500">Tambah Konsultan</h2>

        <form action="{{ route('admin.konsultan.store') }}" method="POST" enctype="multipart/form-data"
            class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            {{-- Username --}}
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-700">Nama</label>
                <input type="text" name="username" value="{{ old('username') }}"
                    class="w-full bg-gray-100 rounded-xl border @error('username') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                    required>
                @error('username') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full bg-gray-100 rounded-xl border @error('email') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                    required>
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- No HP --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">No. HP</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                    class="w-full bg-gray-100 rounded-xl border @error('phone') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                    required>
                @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Password</label>
                <input type="password" name="password"
                    class="w-full bg-gray-100 rounded-xl border @error('password') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                    required>
                @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Konfirmasi
                    Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                    required>
            </div>

            {{-- Keahlian --}}
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-700">Keahlian</label>
                <input type="text" name="keahlian" value="{{ old('keahlian') }}"
                    class="w-full bg-gray-100 rounded-xl border @error('keahlian') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                    required>
                @error('keahlian') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Sertifikasi --}}
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-700">Sertifikasi</label>
                <input type="text" name="sertifikasi" value="{{ old('sertifikasi') }}"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
            </div>

            {{-- Nomor Sertifikat --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Nomor Sertifikat</label>
                <input type="text" name="nomor_sertifikat" value="{{ old('nomor_sertifikat') }}"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
            </div>
            
            {{-- Tanggal Sertifikat --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Tanggal Sertifikat</label>
                <input type="date" name="tanggal_sertifikat" value="{{ old('tanggal_sertifikat') }}"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
            </div>
            
            {{-- Lembaga --}}
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-700">Lembaga Penerbit Sertifikat</label>
                <input type="text" name="lembaga" value="{{ old('lembaga') }}"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
            </div>
            
            {{-- File Sertifikat --}}
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-700">Upload File Sertifikat (Opsional)</label>
                <input type="file" name="file_sertifikat" accept=".pdf,.jpg,.jpeg,.png"
                    class="w-full file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition">
                @error('file_sertifikat') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Bio --}}
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-700">Bio</label>
                <textarea name="bio" rows="3"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">{{ old('bio') }}</textarea>
            </div>

            {{-- Foto Profil --}}
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-700">Foto Profil
                    (Opsional)</label>
                <input type="file" name="foto_profil"
                    class="w-full file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition @error('foto_profil') border-red-500 @enderror">
                @error('foto_profil') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end space-x-4 md:col-span-2 mt-6">
                <a href="{{ route('admin.masterdata.index') }}"
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