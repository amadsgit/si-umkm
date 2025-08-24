@extends('layouts.dashboard')
@section('title', 'Edit Profil Kepala UPTD')

@section('content')
<div class="max-w-5xl mx-auto px-6">
    <div class="bg-white shadow-xl rounded-3xl p-10 border border-gray-200">
        <h1 class="text-2xl font-bold mb-8 text-emerald-500">Edit Profil Kepala UPTD</h1>

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

        <form action="{{ route('dashboard.kepalauptd.update', $kepalauptd->id) }}" method="POST"
            enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Data User --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Nama</label>
                    <input type="text" name="username" value="{{ old('username', $kepalauptd->user->username) }}"
                        class="w-full bg-gray-100 rounded-xl border @error('username') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $kepalauptd->user->email) }}"
                        class="w-full bg-gray-100 rounded-xl border @error('email') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">No HP</label>
                    <input type="text" name="phone" value="{{ old('phone', $kepalauptd->user->phone) }}"
                        class="w-full bg-gray-100 rounded-xl border @error('phone') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                </div>
            </div>

            {{-- Data Kepala UPTD --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">NIP</label>
                    <input type="text" name="nip" value="{{ old('nip', $kepalauptd->nip) }}"
                        class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Jabatan</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan', $kepalauptd->jabatan) }}"
                        class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                </div>
            </div>

            {{-- Status --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Status Aktif</label>
                <select name="status_aktif"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                    <option value="1" {{ old('status_aktif', $kepalauptd->status_aktif) ? 'selected' : '' }}>Aktif
                    </option>
                    <option value="0" {{ old('status_aktif', $kepalauptd->status_aktif) ? '' : 'selected' }}>Tidak Aktif
                    </option>
                </select>
            </div>

            {{-- Upload Foto Profil --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Foto Profil</label>
                <input type="file" name="foto_profil"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-2 transition">
                @if($kepalauptd->foto_profil)
                <div class="mt-3 flex items-center space-x-4">
                    <img src="{{ asset('storage/' . $kepalauptd->foto_profil) }}" alt="Foto Kepala UPTD"
                        class="w-24 h-24 object-cover rounded-xl shadow-md">
                    <p class="text-xs text-gray-500">Foto lama akan diganti jika upload baru</p>
                </div>
                @endif
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('dashboard.kepalauptd.profil') }}"
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