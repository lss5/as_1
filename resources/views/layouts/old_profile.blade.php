<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', App\Setting::where('uniq_name', 'meta_title')->first()->value ?? '')</title>
    <meta name="description" content="@yield('description', App\Setting::where('uniq_name', 'meta_description')->first()->value ?? '')">
    <meta name="keywords" content="@yield('keywords', App\Setting::where('uniq_name', 'meta_keywords')->first()->value ?? '')">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/vendor.js') }}" defer></script>
    @yield('script')
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-white d-flex flex-column h-100">
        <nav class="navbar navbar-expand-md navbar-light">
            @include('partials.nav')
        </nav>

        <hr class="p-0 m-0">

        <main role="main" class="m-0 p-0">
            <div class="container bg-white my-2 py-2">
                <div class="row">
                    <div class="col-md-12 my-2">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link px-2 px-sm-4 {{ (request()->routeIs('profile.index') || request()->routeIs('home.f2a') || request()->routeIs('profile.edit')) ? 'active' : '' }}" href="{{ route('profile.index') }}">{{ __('Profile') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-2 px-sm-4 {{ (request()->routeIs('profile.product.index') || request()->routeIs('profile.product.create') || request()->routeIs('profile.product.edit')) ? 'active' : '' }}" href="{{ route('profile.listing.index') }}">{{ __('product.pages.lists') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-2 px-sm-4 {{ (request()->is('profile/messages*') || request()->is('profile/support*')) ? 'active' : '' }}" href="{{ route('profile.message.index') }}">
                                    {{ __('Messages') }}
                                    <?php $count = Auth::user()->newThreadsCount(); ?>
                                    @if($count > 0)
                                    <span class="badge badge-success badge-pill">{{ $count }}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-2 px-sm-4 disabled" href="#">Apps</a>
                            </li>
                        </ul>
                    </div>
            
                    @include('partials.alerts')
            
                    <div class="col-md-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>

        <footer class="mt-auto">
            <hr class="p-0 m-0">
            @include('partials.footer')
        </footer>
</body>
</html>
