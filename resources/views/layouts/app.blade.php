<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/vendor.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-white d-flex flex-column h-100">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            @include('partials.nav')
        </nav>

        <div class="container">
            @include('partials.alerts')
        </div>

        <main role="main" class="m-0 p-0">
            @yield('content')
        </main>

        <footer class="container mt-auto pt-4 pb-2">
            @include('partials.footer')
        </footer>
</body>
</html>
