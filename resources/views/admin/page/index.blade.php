@extends('admin.layout')

@section('content_p')
<div class="row my-2">
    <div class="col-12">
        <div class="w-100 d-flex flex-row justify-content-between align-items-center">
            <h3>Pages</h3>
            <div class="inline-flex">
                <a href="{{ route('admin.pages.create') }}" type="button" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-plus"></i> Create
                </a>
                <a href="{{ route('admin.products.trashed') }}" type="button" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-sort-numeric-up"></i> {{ __('product.btn.sort') }}
                </a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">List Name</th>
                    <th scope="col">Section</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                    <tr>
                        <th scope="row">{{ $page->id }}</th>
                        <td>{{ $page->name }}</td>
                        <td>{{ $page->list_name }}</td>
                        <td>{{ $page->section->name }}</td>
                        <td>
                            <a href="{{ route('admin.pages.edit', $page) }}" type="button" class="btn btn-warning btn-sm">
                                <i class="fas fa-pen"></i> {{ __('product.btn.change') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
    </div>
</div>
@endsection
