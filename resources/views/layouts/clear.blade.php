<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AsicSeller</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/vendor.js') }}" defer></script>
    <script src="{{ asset('js/adminlte.min.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet">
    @yield('script')
</head>

@yield('content')

</html>
