@extends('landing.layout')

@section('title', 'Daftar UMKM | SIMPKU')

@section('content')
<section class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-20">
    <div class="max-w-4xl mx-auto px-6">
        <div class="bg-white shadow-xl rounded-3xl p-10 border border-gray-200">
            <h2 class="text-4xl font-bold mb-10 text-center text-emerald-500">Daftar UMKM</h2>

            <form action="{{ route('register.umkm') }}" method="POST" enctype="multipart/form-data"
                class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf

                {{-- Nama Lengkap --}}
                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Nama
                        Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full text-black bg-gray-100 rounded-xl border @error('name') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                        placeholder="Contoh: Siti Aminah" autofocus required>
                    @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full text-black bg-gray-100 rounded-xl border @error('email') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                        placeholder="nama@email.com" required>
                    @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- No HP --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">No. HP</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full text-black bg-gray-100 rounded-xl border @error('phone') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                        placeholder="08xxxxxxxxxx" required>
                    @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Password</label>
                    <input type="password" name="password"
                        class="w-full text-black bg-gray-100 rounded-xl border @error('password') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                        placeholder="********" required>
                    @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Konfirmasi
                        Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full text-black bg-gray-100 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                        placeholder="********" required>
                </div>

                {{-- Nama Usaha --}}
                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Usaha</label>
                    <input type="text" name="nama_usaha" value="{{ old('nama_usaha') }}"
                        class="w-full text-black bg-gray-100 rounded-xl border @error('nama_usaha') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                        placeholder="Contoh: Keripik Subang" required>
                    @error('nama_usaha')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bidang Usaha --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Bidang
                        Usaha</label>
                    <input type="text" name="bidang_usaha" value="{{ old('bidang_usaha') }}"
                        class="w-full text-black bg-gray-100 rounded-xl border @error('bidang_usaha') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                        placeholder="Kuliner, Fashion, dll" required>
                    @error('bidang_usaha')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori Usaha --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Kategori
                        Usaha</label>
                    <select name="kategori_usaha"
                        class="w-full text-black bg-gray-100 rounded-xl border @error('kategori_usaha') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition" required>
                        <option value="">-- Pilih --</option>
                        <option value="mikro" {{ old('kategori_usaha')=='mikro' ? 'selected' : '' }}>Mikro</option>
                        <option value="kecil" {{ old('kategori_usaha')=='kecil' ? 'selected' : '' }}>Kecil</option>
                        <option value="menengah" {{ old('kategori_usaha')=='menengah' ? 'selected' : '' }}>Menengah
                        </option>
                    </select>
                    @error('kategori_usaha')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tahun Berdiri --}}
                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Tahun
                        Berdiri</label>
                    <input type="number" name="tahun_berdiri" value="{{ old('tahun_berdiri') }}"
                        class="w-full text-black bg-gray-100 rounded-xl border @error('tahun_berdiri') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                        placeholder="Contoh: 2020" required>
                    @error('tahun_berdiri')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Foto Profil Usaha --}}
                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Foto Profil
                        Usaha</label>
                    <input type="file" name="foto_profil"
                        class="w-full text-black file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition @error('foto_profil') border-red-500 @enderror">
                    @error('foto_profil')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Alamat Usaha --}}
                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Alamat
                        Usaha</label>
                    <textarea name="alamat_usaha" rows="3"
                        class="w-full text-black bg-gray-100 rounded-xl border @error('alamat_usaha') border-red-500 @else border-gray-300 @enderror focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition"
                        placeholder="Jl. Raya Subang No. 10 ..." required></textarea>
                    @error('alamat_usaha')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Submit dan Batal --}}
                <div class="flex justify-end space-x-4 md:col-span-2 mt-8">
                    <a href="{{ url('/') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-8 rounded-xl transition duration-200 shadow-md">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-8 rounded-xl transition duration-200 shadow-md">
                        Daftar Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection