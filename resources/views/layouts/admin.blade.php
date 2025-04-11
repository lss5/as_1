<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AsicSeller Administration</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet">
    @yield('script')
</head>

<body>
    <div class="wrapper">

        @include('admin.partials.navbar')

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('index') }}" class="brand-link">
                <img src="{{ asset('img/logo.png') }}" alt="" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">AsicSeller</span>
            </a>

            @include('admin.partials.sidebar')
        </aside>

        @yield('content')

        <footer class="main-footer">
            <strong>Copyright &copy; 2021-2024 <a href="https://asicseller.com">AsicSeller</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                Develop <b>Sergey Lototcky</b>
            </div>
        </footer>

    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/admin.js') }}" defer></script>
    <script src="{{ asset('js/adminlte.min.js') }}" defer></script>
</body>

</html>
