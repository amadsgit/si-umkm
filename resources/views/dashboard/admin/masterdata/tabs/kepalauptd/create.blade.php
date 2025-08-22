@extends('layouts.dashboard')
@section('title', 'Tambah Data Kepala UPTD')

@section('content')
<div class="max-w-4xl mx-auto px-6">
    <div class="bg-white shadow-xl rounded-3xl p-10 border border-gray-200">
        <h2 class="text-xl font-bold mb-10 text-left text-emerald-500">Tambah Kepala UPTD</h2>

        <form action="{{ route('admin.kepalauptd.store') }}" method="POST" enctype="multipart/form-data"
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
                <label class="block mb-2 text-sm font-semibold text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                    required>
            </div>

            {{-- NIP --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">NIP</label>
                <input type="text" name="nip" value="{{ old('nip') }}"
                    class="w-full bg-gray-100 rounded-xl border @error('nip') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                @error('nip') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Jabatan --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Jabatan</label>
                <input type="text" name="jabatan" value="{{ old('jabatan') }}"
                    class="w-full bg-gray-100 rounded-xl border @error('jabatan') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                @error('jabatan') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Foto Profil --}}
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-700">Foto Profil (Opsional)</label>
                <input type="file" name="foto_profil"
                    class="w-full file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition @error('foto_profil') border-red-500 @enderror">
                @error('foto_profil') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Status Aktif --}}
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-700">Status</label>
                <select name="status_aktif"
                    class="w-full bg-gray-100 rounded-xl border @error('status_aktif') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                    <option value="1" {{ old('status_aktif')=='1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status_aktif')=='0' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status_aktif') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
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