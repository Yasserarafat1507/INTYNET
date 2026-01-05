<<<<<<< HEAD
<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
    @vite('resources/css/app.css')
</head>

<body class="bg-white">
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
