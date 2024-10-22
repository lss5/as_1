<nav class="py-2 bg-light border-bottom">
    <div class="container d-flex flex-wrap align-items-center">
        <ul class="nav me-auto">
            <li class="nav-item"><a href="{{ route('index') }}" class="nav-link link-dark px-2 active" aria-current="page">Home</a></li>
            <li class="nav-item"><a href="{{ route('listings.index') }}" class="nav-link link-dark px-2">Listings</a></li>
            <li class="nav-item"><a href="#" class="nav-link link-dark px-2">FAQs</a></li>
            <li class="nav-item"><a href="#" class="nav-link link-dark px-2">About</a></li>
        </ul>
        @guest
        <ul class="nav">
            <li class="nav-item"><a href="{{ route('login') }}" class="nav-link link-dark px-2">Login</a></li>
            <li class="nav-item"><a href="{{ route('register') }}" class="nav-link link-dark px-2">Sign up</a></li>
        </ul>
        @else
        <div class="flex-shrink-0 dropdown">
            <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                @if (Auth::user()->images->count() > 0)
                    <img src="{{ asset('storage/'.Auth::user()->images->first()->link) }}" alt="Seller" width="36" height="36" class="rounded-circle">
                @else
                    <img src="{{ asset('images/site/no-photo-user.png') }}" alt="default user photo" width="32" height="32" class="rounded-circle">
                @endif
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                <li><a class="dropdown-item" href="{{ route('profile.listings.create') }}">New listing...</a></li>
                <li><a class="dropdown-item" href="{{ route('profile.messages.index') }}">
                    Messages
                    @if(Auth::user()->newThreadsCount() > 0)
                        <span class="badge badge-success badge-pill">{{ Auth::user()->newThreadsCount() }}</span>
                    @endif
                </a></li>
                <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a></li>
                @can('moder')
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('admin.index') }}" class="dropdown-item">
                        Administration
                    </a>
                @endcan
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
        </div>
        @endguest
    </div>
</nav>
<header class="py-3">
    <div class="container d-flex flex-wrap justify-content-center">
        <a href="/" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
            <img src="{{ asset('img/logo.png') }}" alt="" width="36" height="36">
            <span class="fs-3 ms-1">AsicSeller</span>
        </a>
        <form class="col-12 col-lg-auto mb-2 mb-lg-0">
            <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>
    </div>
</header>
