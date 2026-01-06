<!doctype html>
    <html class="h-full">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
        @vite('resources/css/app.css')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    </head>

    <body class="bg-white h-full">
        <header class="shadow-sm sticky top-0 z-50">
            @include('layouts.navbar.header')
        </header>

        <main class="flex justify-center bg-cover bg-center bg-no-repeat py-5 shadow-sm"
            style="background-image: url('{{ asset('images/background.jpg') }}');">
            @yield('content')
        </main>

        <footer class="rounded-base m-4">
            @include('layouts.navbar.footer')
        </footer>
    </body>

    </html>
