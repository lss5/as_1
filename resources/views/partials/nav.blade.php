<div class="container">
    <!-- Image and text -->
    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('img/logo.png') }}" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
        {{ config('app.name', 'AsicSeller') }}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {{ (request()->is('products*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('products.index') }}">Offers <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Partners<span class="sr-only">(current)</span></a>
            </li>
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            <li class="nav-item">
                <a class="nav-link btn btn-sm btn-outline-success text-success py-1 mr-1" href="{{ route('profile.listing.create') }}"><i class="fas fa-plus"></i> New sell<span class="sr-only">(current)</span></a>
            </li>
            @guest
                <li class="nav-item {{ (request()->is('login')) ? 'active' : '' }}">
                    <a class="nav-link py-1" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item {{ (request()->is('register')) ? 'active' : '' }}">
                        <a class="nav-link py-1" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="btn btn-sm btn-success dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a href="{{ route('profile.index') }}" class="dropdown-item">
                            <i class="fas fa-user"></i> {{ __('home.pages.lists') }}
                        </a>
                        <a href="{{ route('profile.listing.index') }}" class="dropdown-item">
                            <i class="fas fa-images"></i> {{ __('product.pages.lists') }}
                        </a>
                        {{-- <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            Settings
                        </a> --}}
                        <a href="{{ route('profile.message.index') }}" class="dropdown-item">
                            <i class="far fa-comments"></i> {{ __('home.menu.messages') }}
                            <?php $count = Auth::user()->newThreadsCount(); ?>
                            @if($count > 0)
                                <span class="badge badge-success badge-pill">{{ $count }}</span>
                            @endif
                        </a>
                        @can('moder')
                            <div class="dropdown-divider"></div>
                        @endcan
                        @can('moder')
                        <a href="{{ route('admin.index') }}" class="dropdown-item">
                            <i class="fas fa-headset"></i> Administration
                        </a>
                        @endcan
                        @can('moder')
                        <a href="{{ route('admin.support.index') }}" class="dropdown-item">
                            <i class="fas fa-headset"></i> {{ __('home.menu.support') }}
                        </a>
                        @endcan
                        @can('moder')
                            <a href="{{ route('admin.settings.index') }}" class="dropdown-item">
                                <i class="far fa-images"></i> App Settings
                            </a>
                        @endcan
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</div>