@extends('layouts.app')

@section('content')
    @can('update', $product)
    <div class="container shadow-sm rounded  py-2 my-2">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('products.edit', $product) }}" type="button" class="btn btn-warning mx-2">Edit</a>
            </div>
        </div>
    </div>
    @endcan
    <div class="container py-3 my-3">
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <h2>{{ $product->title }} Lorem ipsum dolor sit amet consectetur.</h2>
            </div>
            @if ($product->images->count() > 0)
                @foreach ($product->images as $image)
                <div class="col-md-12 col-lg-6 my-1">
                    <img src="{{ asset('storage/'.$image->link) }}" class="img" alt="{{ $product->title }}">
                </div>
                @endforeach
            @else
                <div class="col-md-12 col-lg-6 my-1">
                    <img src="{{ asset('img/product-no-image.jpeg') }}" class="img" alt="{{ $product->title }}">
                </div>
            @endif
            <div class="col-12 my-1">{{ $product->description }}
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam distinctio quisquam voluptates tenetur voluptatem odio nostrum eveniet asperiores repellendus beatae sed animi voluptatibus, architecto debitis et facilis excepturi amet soluta consectetur, similique, exercitationem ipsa! Sequi sunt laudantium dignissimos optio consequuntur?
            </div>
    </div>
@endsection