@extends('home.layout')

@section('content_p')
    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-12 col-lg-4 my-2">
                @include('partials.product_card')
            </div>
        @empty
            <div class="col-12">
                <h3>No products selling</h3>
            </div>
        @endforelse
    </div>
@endsection
