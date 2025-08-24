<aside :class="{ '-translate-x-full': !sidebarOpen }"
    class="bg-white shadow-xl w-64 fixed inset-y-0 left-0 transform md:relative md:translate-x-0 transition duration-200 ease-in-out z-50 border-r border-sky-200">

    <!-- Logo -->
    <div class="p-6 flex items-center border-b border-sky-100">
        <img src="{{ asset('images/favicon.png') }}" alt="Logo" class="w-8 h-8 mr-2">
        <h1 class="text-3xl font-extrabold text-sky-600 tracking-wide">SIMPKU</h1>
    </div>

    <!-- Menu -->
    <nav class="mt-8 space-y-1 px-4 text-sm font-medium">

        {{-- MENU UNTUK ROLE UMKM --}}
        @if(Auth::user()->role === 'umkm')
        <a href="{{ route('dashboard.umkm.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('dashboard.umkm.index') ? 'bg-sky-100 text-sky-900 font-semibold' : 'text-sky-800 hover:bg-sky-100' }}">
            <i class="ph ph-gauge text-xl"></i> Dashboard
        </a>
        <a href="{{ route('dashboard.umkm.profil') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('dashboard.umkm.profil') ? 'bg-sky-100 text-sky-900 font-semibold' : 'text-sky-800 hover:bg-sky-100' }}">
            <i class="ph ph-user-circle text-xl"></i> Profil UMKM
        </a>
        <a href="{{ route('dashboard.umkm.konsultasi.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('dashboard.umkm.konsultasi.*') ? 'bg-sky-100 text-sky-900 font-semibold' : 'text-sky-800 hover:bg-sky-100' }}">
            <i class="ph ph-chat-dots text-xl"></i> Konsultasi
        </a>
        <a href="{{ route('dashboard.umkm.pembinaan.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('dashboard.umkm.pembinaan.*') ? 'bg-sky-100 text-sky-900 font-semibold' : 'text-sky-800 hover:bg-sky-100' }}">
            <i class="ph ph-graduation-cap text-xl"></i> Pembinaan
        </a>

        {{-- MENU UNTUK ROLE KONSULTAN --}}
        @elseif(Auth::user()->role === 'konsultan')
        <a href="{{ route('dashboard.konsultan.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('dashboard.konsultan.index') ? 'bg-sky-100 text-sky-900 font-semibold' : 'text-sky-800 hover:bg-sky-100' }}">
            <i class="ph ph-gauge text-xl"></i> Dashboard
        </a>
        <a href="{{ route('dashboard.konsultan.profil') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('dashboard.konsultan.profil') ? 'bg-sky-100 text-sky-900 font-semibold' : 'text-sky-800 hover:bg-sky-100' }}">
            <i class="ph ph-user-circle text-xl"></i> Profil Konsultan
        </a>
        <a href="{{ route('dashboard.konsultan.konsultasi.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('dashboard.konsultan.konsultasi.*') ? 'bg-sky-100 text-sky-900 font-semibold' : 'text-sky-800 hover:bg-sky-100' }}">
            <i class="ph ph-chat-dots text-xl"></i> Jadwal Konsultasi
        </a>

        {{-- MENU UNTUK KEPALA UPTD --}}
        @elseif(Auth::user()->role === 'kepala_uptd')
        <a href="{{ route('dashboard.kepalauptd.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('dashboard.kepalauptd.index') ? 'bg-sky-100 text-sky-900 font-semibold' : 'text-sky-800 hover:bg-sky-100' }}">
            <i class="ph ph-gauge text-xl"></i> Dashboard
        </a>
        <a href="{{ route('dashboard.kepalauptd.profil') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('dashboard.kepalauptd.profil') ? 'bg-sky-100 text-sky-900 font-semibold' : 'text-sky-800 hover:bg-sky-100' }}">
            <i class="ph ph-user-circle text-xl"></i> Profil Kepala UPTD
        </a>
        <a href="{{ route('dashboard.kepalauptd.laporan') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('dashboard.kepalauptd.laporan') ? 'bg-sky-100 text-sky-900 font-semibold' : 'text-sky-800 hover:bg-sky-100' }}">
            <i class="ph ph-chat-dots text-xl"></i> Laporan & Rekapitulasi
        </a>

        {{-- MENU UNTUK ROLE ADMIN --}}
        @elseif(Auth::user()->role === 'admin')
        <a href="{{ route('dashboard.admin') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('dashboard.admin') ? 'bg-sky-100 text-sky-900 font-semibold' : 'text-sky-800 hover:bg-sky-100' }}">
            <i class="ph ph-gauge text-xl"></i> Dashboard
        </a>
        <a href="{{ route('admin.masterdata.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('admin.masterdata.*') ? 'bg-sky-100 text-sky-900 font-semibold' : 'text-sky-800 hover:bg-sky-100' }}">
            <i class="ph ph-database text-xl"></i> Master Data
        </a>
        <a href="{{ route('admin.topik-konsultasi.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('admin.topik-konsultasi.*') ? 'bg-sky-100 text-sky-900 font-semibold' : 'text-sky-800 hover:bg-sky-100' }}">
            <i class="ph ph-list-bullets text-xl"></i> Topik Konsultasi
        </a>
        <a href="{{ route('dashboard.admin.jadwalkonsultasi.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('dashboard.admin.jadwalkonsultasi.*') ? 'bg-sky-100 text-sky-900 font-semibold' : 'text-sky-800 hover:bg-sky-100' }}">
            <i class="ph ph-calendar-check text-xl"></i> Jadwal Konsultasi
        </a>
        <a href="{{ route('admin.jenis-pembinaan.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('admin.jenis-pembinaan.*') ? 'bg-sky-100 text-sky-900 font-semibold' : 'text-sky-800 hover:bg-sky-100' }}">
            <i class="ph ph-pencil-simple text-xl"></i> Kelola Pembinaan
        </a>
        <a href="{{ route('admin.jadwal-pembinaan.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('admin.jadwal-pembinaan.*') ? 'bg-sky-100 text-sky-900 font-semibold' : 'text-sky-800 hover:bg-sky-100' }}">
            <i class="ph ph-calendar-heart text-xl"></i> Jadwal Pembinaan
        </a>
        <a href="#"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sky-800 hover:bg-sky-100 transition">
            <i class="ph ph-clock-counter-clockwise text-xl"></i> Riwayat Kegiatan
        </a>
        <a href="#"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sky-800 hover:bg-sky-100 transition">
            <i class="ph ph-star-half text-xl"></i> Feedback & Rating
        </a>
        @endif

    </nav>
</aside>