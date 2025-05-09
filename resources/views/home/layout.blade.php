@extends('layouts.app')

@section('content')
<div class="container bg-white my-2 py-2">
    <div class="row">
        <div class="col-md-12 my-2">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link px-2 px-sm-4 {{ (request()->routeIs('home.index') || request()->routeIs('home.f2a') || request()->routeIs('home.edit')) ? 'active' : '' }}" href="{{ route('profile.index') }}">{{ __('Profile') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-2 px-sm-4 {{ (request()->routeIs('home.products') || request()->routeIs('products.create') || request()->routeIs('products.edit')) ? 'active' : '' }}" href="{{ route('profile.listing.index') }}">{{ __('product.pages.lists') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-2 px-sm-4 {{ (request()->is('messages*') || request()->is('support*')) ? 'active' : '' }}" href="{{ route('profile.message.index') }}">
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
            @yield('content_p')
        </div>
    </div>
</div>
@endsection
