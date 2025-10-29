<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'SIMPKU Kab. Subang')</title>
    <link rel="icon" href="/images/favicon.png" />

    <!-- CSS Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- AOS Animation & Swiper CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />

    <!-- Icon Libraries -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-y2fA6T9t9OrHCOqYyW3PtMJ4Oe6AYCML+Odq7BjP+Q+fqdrD7u1PV0WOVDTPxJcnBHPnMv2QO2I8jCScq4RywA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-white text-gray-800 dark:bg-gray-900 dark:text-white font-sans">
    <!-- ====== Flash Message ====== -->
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

    <!-- ====== Main Content ====== -->
    @yield('content')

    <!-- ====== JS Libraries ====== -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
                duration: 800,
                once: true,
            });
        
            new Swiper(".mySwiper", {
                loop: true,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
            });
    </script>
</body>

</html>