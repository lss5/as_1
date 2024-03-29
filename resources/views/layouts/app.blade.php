<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AsicSeller') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/vendor.js') }}" defer></script>
    @yield('script')

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-white d-flex flex-column h-100">
        <nav class="navbar navbar-expand-md navbar-light">
        {{-- <nav class="navbar navbar-light" style="background-color: #fff;"> --}}
            @include('partials.nav')

        </nav>
        <hr class="p-0 m-0">

        <main role="main" class="m-0 p-0">
            @yield('content')
        </main>

        <footer class="mt-auto">
            <hr class="p-0 m-0">
            @include('partials.footer')
        </footer>
</body>
</html>
