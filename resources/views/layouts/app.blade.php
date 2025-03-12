<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', \App\Models\Setting::where('uniq_name', 'meta_title')->first()->value ?? '')</title>
    <meta name="description" content="@yield('description', \App\Models\Setting::where('uniq_name', 'meta_description')->first()->value ?? '')">
    <meta name="keywords" content="@yield('keywords', \App\Models\Setting::where('uniq_name', 'meta_keywords')->first()->value ?? '')">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/vendor.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-white d-flex flex-column h-100">
        @include('partials.navbar')

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
