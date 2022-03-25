<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link px-2 px-sm-4 {{ (request()->routeIs('home.index')) ? 'active' : '' }}" href="{{ route('home.index') }}">{{ __('Profile') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link px-2 px-sm-4 {{ (request()->routeIs('home.listings')) ? 'active' : '' }}" href="{{ route('home.listings') }}">{{ __('Listings') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link px-2 px-sm-4 {{ (request()->routeIs('home.settings')) ? 'active' : '' }}" href="{{ route('home.settings') }}">{{ __('Settings') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link px-2 px-sm-4 {{ (request()->is('home/messages*')) ? 'active' : '' }}" href="{{ route('home.messages.index') }}">
            {{ __('Messages') }}
            <?php $count = Auth::user()->newThreadsCount(); ?>
            @if($count > 0)
                <span class="badge badge-success badge-pill">{{ $count }}</span>
            @endif
        </a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link disabled">Subscription</a>
    </li> --}}
</ul>