@extends('admin.layout')

@section('content_p')

<div class="row my-2">
    <div class="col-12">
        <h3>App Settings</h3>
    </div>
    <div class="col-12">
        {{-- Categories --}}
        <div class="w-100 d-flex flex-row justify-content-between align-items-center mb-1 mt-3">
            <h5 class="m-0">{{ __('home.pages.categories') }}</h5>
            <div class="inline-flex">
                <a href="{{ route('admin.categories.create') }}" type="button" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-plus"></i> {{ __('product.btn.add') }}
                </a>
                <a href="#" type="button" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-sort-numeric-up"></i> {{ __('product.btn.sort') }}
                </a>
            </div>
        </div>
        @isset($categories)
            <ul class="list-group">
                @foreach ($categories as $category)
                <li class="list-group-item d-flex flex-row justify-content-between align-items-center">
                    {{ $category->name }}<span class="badge badge-secondary">{{ $category->sort }}</span>
                    <div class="inline-flex">
                        <a href="{{ route('admin.categories.edit', $category) }}" type="button" class="btn btn-warning btn-sm">
                            <i class="fas fa-pen"></i> {{ __('product.btn.change') }}
                        </a>
                    </div>
                </li>
                @endforeach
            </ul>
        @endisset
        {{-- Sections --}}
        <div class="w-100 d-flex flex-row justify-content-between align-items-center mb-1 mt-3">
            <h5 class="m-0">Sections</h5>
            <div class="inline-flex">
                <a href="{{ route('admin.sections.create') }}" type="button" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-plus"></i> {{ __('product.btn.add') }}
                </a>
                <a href="#" type="button" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-sort-numeric-up"></i> {{ __('product.btn.sort') }}
                </a>
            </div>
        </div>
        @isset($sections)
            <ul class="list-group">
                @foreach ($sections as $section)
                <li class="list-group-item d-flex flex-row justify-content-between align-items-center">
                    {{ $section->name }}<span class="badge badge-secondary">{{ $section->sort }}</span>
                    <div class="inline-flex">
                        <a href="{{ route('admin.sections.edit', $section) }}" type="button" class="btn btn-warning btn-sm">
                            <i class="fas fa-pen"></i> {{ __('product.btn.change') }}
                        </a>
                        {{-- <a href="{{ route('admin.section.trashed') }}" type="button" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-trash"></i> {{ __('product.btn.delete') }}
                        </a> --}}
                    </div>
                </li>
                @endforeach
            </ul>
        @endisset
        {{-- settings --}}
        <div class="w-100 d-flex flex-row justify-content-between align-items-center mb-1 mt-3">
            <h5 class="m-0">Settings</h5>
            <div class="inline-flex">
                <a href="{{ route('admin.settings.create') }}" type="button" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-plus"></i> {{ __('product.btn.add') }}
                </a>
            </div>
        </div>
        @isset($settings)
            <ul class="list-group">
                @foreach ($settings as $setting)
                <li class="list-group-item d-flex flex-row justify-content-between align-items-center">
                    {{ $setting->name }}: {{ $setting->value }}
                    <div class="inline-flex">
                        <a href="{{ route('admin.settings.edit', $setting) }}" type="button" class="btn btn-warning btn-sm">
                            <i class="fas fa-pen"></i> {{ __('product.btn.change') }}
                        </a>
                    </div>
                </li>
                @endforeach
            </ul>
        @endisset
        {{-- Manufacturers --}}
        <div class="w-100 d-flex flex-row justify-content-between align-items-center mb-1 mt-3">
            <h5 class="m-0">Manufacturers</h5>
            <div class="inline-flex">
                <a href="{{ route('admin.manufacturers.create') }}" type="button" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-plus"></i> {{ __('product.btn.add') }}
                </a>
                <a href="#" type="button" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-sort-numeric-up"></i> {{ __('product.btn.sort') }}
                </a>
            </div>
        </div>
        @isset($manufacturers)
            <ul class="list-group">
                @foreach ($manufacturers as $manufacturer)
                <li class="list-group-item d-flex flex-row justify-content-between align-items-center">
                    {{ $manufacturer->name }}<span class="badge badge-secondary">{{ $manufacturer->sort }}</span>
                    <div class="inline-flex">
                        <a href="{{ route('admin.manufacturers.edit', $manufacturer) }}" type="button" class="btn btn-warning btn-sm">
                            <i class="fas fa-pen"></i> {{ __('product.btn.change') }}
                        </a>
                    </div>
                </li>
                @endforeach
            </ul>
        @endisset
    </div>
</div>
@endsection
