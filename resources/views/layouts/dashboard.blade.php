<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title') | SIMPKU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/images/favicon.png" />
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- CSS Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Phosphor Icons --> 
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    @stack('styles')
</head>

<body class="bg-gradient-to-br from-sky-50 to-sky-100 min-h-screen text-gray-800 font-sans">

    @if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
        class="fixed top-5 left-1/2 -translate-x-1/2 bg-emerald-600 text-white font-semibold px-6 py-3 rounded-xl shadow-lg z-50">
        {{ session('success') }}
    </div>
    @endif
    
    @if (session('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
        class="fixed top-5 left-1/2 -translate-x-1/2 bg-red-600 text-white font-semibold px-6 py-3 rounded-xl shadow-lg z-50">
        {{ session('error') }}
    </div>
    @endif
    
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main -->
        <div class="flex-1 flex flex-col overflow-hidden bg-white shadow-inner">

            <!-- Topbar -->
            @include('components.topbar')

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gradient-to-br from-white via-emerald-50 to-sky-50">
                @yield('content')
            </main>

            <!-- Footer -->
            @include('components.footer')
        </div>
    </div>
@stack('scripts')
</body>

</html>