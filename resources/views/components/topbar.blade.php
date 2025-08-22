<header
    class="bg-gradient-to-r from-emerald-500 to-sky-500 text-white px-6 py-4 flex justify-between items-center shadow-md sticky top-0 z-40">

    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = !sidebarOpen" class="md:hidden focus:outline-none">
            <i class="ph ph-list text-2xl"></i>
        </button>
        <h1 class="text-xl font-semibold">Dashboard</h1>
    </div>

    <!-- User Dropdown -->
    <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center gap-3 focus:outline-none">
            <!-- Avatar (ambil dari database jika ada, fallback ke avatar generator) -->
            <img src="{{ Auth::user()->umkm && Auth::user()->umkm->foto_profil
                            ? asset('storage/' . Auth::user()->umkm->foto_profil)
                            : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->username) . '&background=10B981&color=fff' }}"
                alt="Avatar" class="w-9 h-9 rounded-full border-2 border-white object-cover shadow-md">

            <!-- Username -->
            <span class="hidden md:inline text-sm font-medium">{{ Auth::user()->username }}</span>
            <i class="ph ph-caret-down text-sm"></i>
        </button>

        <!-- Dropdown Menu -->
        <div x-show="open" @click.away="open = false" x-transition
            class="absolute right-0 mt-2 w-52 bg-white text-gray-700 rounded-xl shadow-lg py-2 z-50 border border-gray-200">
            {{-- <a href="#" class="flex items-center gap-2 px-4 py-2 hover:bg-emerald-100 transition">
                <i class="ph ph-user text-lg"></i> Profil
            </a> --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-emerald-100 transition">
                    <i class="ph ph-sign-out text-lg"></i> Sign Out
                </button>
            </form>
        </div>
    </div>
</header>