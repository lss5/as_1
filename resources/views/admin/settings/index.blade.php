@extends('layouts.app')

@section('content')
<div class="container shadow-sm bg-white rounded py-3">
    @include('partials.alerts')

    <div class="row my-2">
        <div class="col-12">
            <h3>App Settings</h3>
        </div>
        <div class="col-12">
            <div class="w-100 d-flex flex-row justify-content-between align-items-center">
                <h5>{{ __('home.pages.categories') }}</h5>
                <div class="inline-flex">
                    <a href="{{ route('admin.products.index') }}" type="button" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-plus"></i> {{ __('product.btn.add') }}
                    </a>
                    <a href="{{ route('admin.products.trashed') }}" type="button" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-sort-numeric-up"></i> {{ __('product.btn.sort') }}
                    </a>
                </div>
            </div>
            @isset($categories)
            <ul class="list-group">
                @foreach ($categories as $category)
                <li class="list-group-item d-flex flex-row justify-content-between align-items-center">
                    {{ $category->name }}
                    <div class="inline-flex">
                        <a href="{{ route('admin.products.index') }}" type="button" class="btn btn-warning btn-sm">
                            <i class="fas fa-pen"></i> {{ __('product.btn.change') }}
                        </a>
                        <a href="{{ route('admin.products.trashed') }}" type="button" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-trash"></i> {{ __('product.btn.delete') }}
                        </a>
                    </div>
                </li>
                @endforeach
            </ul>
            @endisset
        </div>
    </div>
</div>
@endsection
