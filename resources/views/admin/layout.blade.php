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
                @can('moder')
                    <li class="nav-item">
                        <a class="nav-link px-2 px-sm-4 {{ (request()->routeIs('admin.support.index')) ? 'active' : '' }}" href="{{ route('admin.support.index') }}"><i class="fas fa-headset"></i> Help requests</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-2 px-sm-4 {{ (request()->routeIs('admin.products.index')) ? 'active' : '' }}" href="{{ route('admin.products.index') }}"><i class="far fa-images"></i> Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-2 px-sm-4 {{ (request()->routeIs('admin.users.index')) ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="fas fa-users-cog"></i> Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-2 px-sm-4 {{ (request()->routeIs('admin.pages.index')) ? 'active' : '' }}" href="{{ route('admin.pages.index') }}"><i class="fas fa-file-alt"></i> Pages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-2 px-sm-4 {{ (request()->routeIs('admin.settings.index')) ? 'active' : '' }}" href="{{ route('admin.settings.index') }}"><i class="fas fa-cog"></i> App Settings</a>
                    </li>
                @endcan
            </ul>
        </div>

        @include('partials.alerts')

        <div class="col-md-12">
            @yield('content_p')
        </div>
    </div>
</div>
@endsection
