@extends('layouts.dashboard')
@section('title', 'Edit Profil Konsultan')

@section('content')
<div class="max-w-5xl mx-auto px-6">
    <div class="bg-white shadow-xl rounded-3xl p-10 border border-gray-200">
        <h1 class="text-2xl font-bold mb-8 text-emerald-500">Edit Profil Konsultan</h1>

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

        <form action="{{ route('dashboard.konsultan.update', $konsultan->id) }}" method="POST"
            enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Data User --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Nama</label>
                    <input type="text" name="username" value="{{ old('username', $konsultan->user->username) }}"
                        class="w-full bg-gray-100 rounded-xl border @error('username') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                    @error('username') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $konsultan->user->email) }}"
                        class="w-full bg-gray-100 rounded-xl border @error('email') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">No HP</label>
                    <input type="text" name="phone" value="{{ old('phone', $konsultan->user->phone) }}"
                        class="w-full bg-gray-100 rounded-xl border @error('phone') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                    @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Data Konsultan --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Keahlian</label>
                <input type="text" name="keahlian" value="{{ old('keahlian', $konsultan->keahlian) }}"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Sertifikasi</label>
                <input type="text" name="sertifikasi" value="{{ old('sertifikasi', $konsultan->sertifikasi) }}"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Nomor Sertifikat</label>
                    <input type="text" name="nomor_sertifikat"
                        value="{{ old('nomor_sertifikat', $konsultan->nomor_sertifikat) }}"
                        class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Tanggal Sertifikat</label>
                    <input type="date" name="tanggal_sertifikat"
                        value="{{ old('tanggal_sertifikat', $konsultan->tanggal_sertifikat) }}"
                        class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                </div>
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Lembaga</label>
                <input type="text" name="lembaga" value="{{ old('lembaga', $konsultan->lembaga) }}"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Bio</label>
                <textarea name="bio" rows="3"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">{{ old('bio', $konsultan->bio) }}</textarea>
            </div>

            {{-- Status --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Status Aktif</label>
                <select name="status_aktif"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition">
                    <option value="1" {{ old('status_aktif', $konsultan->status_aktif) ? 'selected' : '' }}>Aktif
                    </option>
                    <option value="0" {{ old('status_aktif', $konsultan->status_aktif) ? '' : 'selected' }}>Tidak Aktif
                    </option>
                </select>
            </div>

            {{-- Upload Foto Profil --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Foto Profil</label>
                <input type="file" name="foto_profil"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-2 transition">
                @if($konsultan->foto_profil)
                <div class="mt-3 flex items-center space-x-4">
                    <img src="{{ asset('storage/' . $konsultan->foto_profil) }}" alt="Foto Konsultan"
                        class="w-24 h-24 object-cover rounded-xl shadow-md">
                    <p class="text-xs text-gray-500">Foto lama akan diganti jika upload baru</p>
                </div>
                @endif
            </div>

            {{-- Upload File Sertifikat --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">File Sertifikat</label>
                <input type="file" name="file_sertifikat"
                    class="w-full bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-2 transition">
                @if($konsultan->file_sertifikat)
                <div class="mt-3">
                    <a href="{{ asset('storage/' . $konsultan->file_sertifikat) }}" target="_blank"
                        class="text-blue-600 underline">Lihat Sertifikat</a>
                </div>
                @endif
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('dashboard.konsultan.profil') }}"
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