@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('partials.search')
    </div>
    <hr class="pt-1">
    <div class="row">
        @if($products->count() < 1)
            <div class="col-12">
                <h5>No find results</h5>
            </div>
        @else
            <div class="col-12">
                <h5>Search results</h5>
            </div>
            @forelse ($products as $product)
            <div class="col-sm-12 col-md-6 col-lg-4 mt-2">
                @include('partials.product_card')
            </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
