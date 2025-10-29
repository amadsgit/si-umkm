@extends('landing.layout')
@section('title', 'Beranda | SIMPKU Kab. Subang')

@section('content')
    <!-- ====== Navbar ====== -->
    <header class="fixed top-0 w-full z-50 bg-white/70 text-black backdrop-blur-lg shadow-sm transition-all">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
            <a href="#" class="flex items-center space-x-2">
                <img src="{{ asset('images/logosimpku.png') }}" alt="Logo SIMPKU" class="h-8 sm:h-10" />
                <span class="text-xl font-semibold text-primary">
                    Sistem Informasi Manajemen Pembinaan & Konsultasi UMKM
                </span>
            </a>
            <div class="hidden md:flex items-center space-x-6 text-sm font-medium">
                <a href="#" class="hover:text-primary transition">Home</a>
                <a href="#manfaat" class="hover:text-primary transition">Manfaat</a>
                <a href="#langkah" class="hover:text-primary transition">Langkah</a>
                <a href="#testimoni" class="hover:text-primary transition">Testimoni</a>
                <a href="#kontak" class="hover:text-primary transition">Kontak</a>
                <a href="/login" class="bg-primary hover:bg-emerald-600 text-black hover:text-white px-4 py-2 rounded transition shadow">
                    Login
                </a>
            </div>
            <button class="md:hidden focus:outline-none">
                <!-- Hamburger menu bisa ditambahkan di sini -->
            </button>
        </nav>
    </header>

    <!-- ====== Hero Section ====== -->
    <section class="bg-gradient-to-r from-emerald-600 to-green-400 pt-12 pb-12">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-10 px-6">
            <div class="md:w-1/2" data-aos="fade-right">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">
                    Layanan Konsultasi & Pembinaan UMKM
                </h1>
                <p class="text-lg mb-6">
                    Bantu UMKM naik kelas dengan pendampingan digital yang mudah, cepat, dan terpercaya.
                </p>
                <a href="{{ route('register.umkm.form') }}"
                class="bg-white text-emerald-700 font-semibold px-6 py-3 rounded-full hover:bg-gray-200 transition">
                Daftar Sekarang
                </a>
            </div>
            <div class="md:w-1/2" data-aos="fade-left">
                <img src="{{ asset('images/logosimpku.png') }}" alt="Ilustrasi UMKM" class="rounded-xl" />
            </div>
        </div>
    </section>

    <!-- ====== Manfaat Section ====== -->
    <section id="manfaat" class="py-20 text-gray-700 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-12" data-aos="fade-up">Manfaat Layanan UMKM</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl transition"
                    data-aos="fade-up" data-aos-delay="100">
                    <div class="text-blue-600 text-4xl mb-4">🎓</div>
                    <h3 class="text-xl font-semibold mb-2">Konsultasi Gratis</h3>
                    <p>Dapatkan pendampingan dari ahli tanpa biaya untuk berbagai kebutuhan UMKM.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl transition"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="text-green-500 text-4xl mb-4">💡</div>
                    <h3 class="text-xl font-semibold mb-2">Pelatihan Usaha</h3>
                    <p>Strategi bisnis, pemasaran, dan pengelolaan keuangan untuk UMKM Anda.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl transition"
                    data-aos="fade-up" data-aos-delay="300">
                    <div class="text-yellow-500 text-4xl mb-4">🌐</div>
                    <h3 class="text-xl font-semibold mb-2">Akses Jaringan</h3>
                    <p>Terhubung dengan instansi, investor, dan peluang pasar melalui digitalisasi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== Langkah Section ====== -->
    <section id="langkah" class="py-20 text-gray-700 bg-white">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl text-emerald-600 font-bold mb-12" data-aos="fade-up">3 Langkah Mudah Menggunakan Sistem</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="p-6 bg-emerald-100 text-gray-800 rounded-xl shadow transition"
                    data-aos="zoom-in" data-aos-delay="100">
                    <div class="text-5xl font-bold mb-2">1</div>
                    <h3 class="font-semibold mb-2">Daftar Akun</h3>
                    <p>Isi formulir pendaftaran untuk mendapatkan akses.</p>
                </div>
                <div class="p-6 bg-emerald-100 text-gray-800 rounded-xl shadow transition"
                    data-aos="zoom-in" data-aos-delay="200">
                    <div class="text-5xl font-bold mb-2">2</div>
                    <h3 class="font-semibold mb-2">Pilih Layanan</h3>
                    <p>Tentukan jenis konsultasi atau pelatihan yang Anda butuhkan.</p>
                </div>
                <div class="p-6 bg-emerald-100 text-gray-800 rounded-xl shadow transition"
                    data-aos="zoom-in" data-aos-delay="300">
                    <div class="text-5xl font-bold mb-2">3</div>
                    <h3 class="font-semibold mb-2">Mulai Berkonsultasi</h3>
                    <p>Tim ahli kami akan segera menghubungi Anda.</p>
                </div>
            </div>
        </div>
    </section>

   <!-- ====== Jadwal Pembinaan Terdekat ====== -->
    <section id="pembinaan" class="py-20 text-gray-700 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-10" data-aos="fade-up">Jadwal Pembinaan Terdekat</h2>

            @if ($jadwalPembinaanList->isEmpty())
            <div class="bg-white rounded-2xl shadow-md p-10 text-center text-gray-600 max-w-2xl mx-auto" data-aos="fade-up">
                {{-- <i class="ph ph-calendar-x text-5xl text-gray-400 mb-4"></i> --}}
                <div class="flex items-center justify-center mb-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-orange-100 text-orange-600">
                        <i class="ph ph-info text-2xl"></i>
                    </div>
                </div>
                <p class="text-lg font-medium">
                    Saat ini belum terdapat jadwal pembinaan UMKM yang tersedia.
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    Silakan periksa kembali pada waktu mendatang untuk mendapatkan informasi pembinaan terbaru.
                </p>
            </div>
            @else
            <div class="grid md:grid-cols-3 gap-8">
                @foreach ($jadwalPembinaanList->take(3) as $pembinaan)
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2"
                    data-aos="fade-up">

                    {{-- Thumbnail --}}
                    <div class="relative overflow-hidden">
                        @if ($pembinaan->thumbnail)
                        <img src="{{ asset('storage/' . $pembinaan->thumbnail) }}" alt="{{ $pembinaan->judul }}"
                            class="w-full h-48 object-cover group-hover:scale-110 transition duration-500">
                        @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                            Tidak ada gambar
                        </div>
                        @endif

                        {{-- Label kategori/metode --}}
                        <span class="absolute top-3 left-3 bg-emerald-600 text-white text-xs px-3 py-1 rounded-full shadow">
                            {{ ucfirst($pembinaan->metode) }}
                        </span>
                    </div>

                    <div class="p-6 text-left">
                        {{-- Judul --}}
                        <h3 class="text-lg font-bold mb-3 text-emerald-700 group-hover:text-emerald-800 transition">
                            {{ $pembinaan->judul }}
                        </h3>

                        {{-- Tanggal & Waktu --}}
                        <div class="flex items-center text-sm text-gray-600 mb-2">
                            <i class="ph ph-calendar mr-2 text-emerald-500"></i>
                            {{ \Carbon\Carbon::parse($pembinaan->tanggal)->translatedFormat('d F Y') }}
                        </div>
                        <div class="flex items-center text-sm text-gray-600 mb-2">
                            <i class="ph ph-clock mr-2 text-emerald-500"></i>
                            {{ \Carbon\Carbon::parse($pembinaan->waktu_mulai)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($pembinaan->waktu_selesai)->format('H:i') }}
                        </div>

                        {{-- Lokasi --}}
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="ph ph-map-pin mr-2 text-emerald-500"></i>
                            {{ $pembinaan->lokasi }}
                        </div>

                        {{-- Tombol --}}
                        <a href="/login"
                            class="block w-full text-center bg-sky-600 hover:bg-emerald-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                            Ikuti Sekarang
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </section>

    <!-- ====== Testimoni Section ====== -->
    <section id="testimoni" class="py-20 text-gray-700 bg-gray-100">
        <div class="max-w-4xl mx-auto text-center px-6">
            <h2 class="text-3xl text-emerald-600 font-bold mb-10" data-aos="fade-up">Apa Kata UMKM?</h2>
            <div class="swiper mySwiper" data-aos="fade-up" data-aos-delay="200">
                <div class="swiper-wrapper">
                    <div
                        class="swiper-slide bg-white p-6 rounded-xl shadow hover:scale-105 transition">
                        <p class="italic mb-4">"Layanan ini sangat membantu saya memasarkan produk secara digital!"</p>
                        <h4 class="font-semibold">Siti Aminah – UMKM Makanan</h4>
                    </div>
                    <div
                        class="swiper-slide bg-white p-6 rounded-xl shadow hover:scale-105 transition">
                        <p class="italic mb-4">"Saya jadi paham keuangan dan strategi bisnis. Keren!"</p>
                        <h4 class="font-semibold">Budi Santoso – UMKM Fashion</h4>
                    </div>
                    <div
                        class="swiper-slide bg-white p-6 rounded-xl shadow hover:scale-105 transition">
                        <p class="italic mb-4">"Dengan pelatihan ini, penjualan online saya meningkat!"</p>
                        <h4 class="font-semibold">Yuli Handayani – UMKM Kerajinan</h4>
                    </div>
                </div>
                <div class="swiper-pagination mt-6"></div>
            </div>
        </div>
    </section>

    <!-- ====== Kontak Section ====== -->
    <section id="kontak" class="py-20 bg-white text-gray-700 px-6">
        <div class="max-w-4xl mx-auto text-center" data-aos="fade-up">
            <h2 class="text-3xl font-bold mb-4">Kontak & Bantuan</h2>
            <p class="mb-6">UPTD Dinas Koperasi & UMKM Kab. Subang — Konsultasi Gratis untuk Usaha Mikro Anda</p>
            <div class="space-y-2 text-sm">
                <p>📍 Jl. KS.Tubun, Kabupaten Subang</p>
                <p>☎️ (021) 123-4567</p>
                <p>📧 konsultasiumkm@subangkab.go.id</p>
            </div>
            <a href="/login"
                class="mt-6 inline-block bg-primary text-white px-6 py-3 rounded-full hover:bg-emerald-700 transition font-semibold">
                Masuk ke Sistem
            </a>
        </div>
    </section>

    <!-- ====== Footer ====== -->
    <footer class="py-6 bg-gradient-to-r from-emerald-600 to-green-400 text-white text-center">
        &copy; 2025 UPTD Konsultasi UMKM. All rights reserved.
    </footer>

@endsection