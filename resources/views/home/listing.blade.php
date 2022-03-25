@extends('home.layout')

@section('content_p')
    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-12 col-lg-4 my-2">
                @include('partials.product_card_home')
            </div>
        @empty
            <div class="col-12">
                <h2 class="h4">No products selling</h2>
            </div>
        @endforelse
        <div class="col-12 d-flex justify-content-center my-1">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
@endsection
