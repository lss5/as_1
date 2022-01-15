@extends('layouts.app')

@section('content')
<div class="container shadow-sm bg-white rounded py-3">
    <div class="row">
        <div class="col-12">
            <h3>Manage listings</h3>
        </div>
        @empty($products)
            <div class="col-12">
                <h4>No product created</h4>
            </div>
        @endempty
        @isset($products)
            <div class="col-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Creator</th>
                        <th scope="col">Create</th>
                        <th scope="col">Update</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <th scope="row">{{ $product->id }}</th>
                        <td><a href="{{ route('admin.products.show', $product) }}">{{ $product->title }}</a></td>
                        <td>{{ $product->user->name }}</td>
                        <td>{{ date('d-m-Y H:i:s', strtotime($product->created_at)) }}</td>
                        <td>{{ date('d-m-Y H:i:s', strtotime($product->updated_at)) }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endisset
    </div>
</div>
@endsection
