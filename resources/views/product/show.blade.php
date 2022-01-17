@extends('layouts.app')

@section('content')
    <div class="container shadow-sm bg-white rounded py-3">
        <h2>{{ $product->title }}</h2>
        <div class="row">
            <div class="col-md-12 col-lg-12"></div>
            <div class="col-md-12 col-lg-12">
                @if ($product->images->count() > 0)
                    @foreach ($product->images as $image)
                        <img src="{{ asset('storage/'.$image->link) }}" class="img" alt="{{ $product->title }}">
                    @endforeach
                @else
                    <img src="{{ asset('img/product-no-image.jpeg') }}" class="img" alt="{{ $product->title }}">
                @endif
            </div>
            <div class="col-12">{{ $product->description }}</div>
        </div>
        
    </div>
@endsection