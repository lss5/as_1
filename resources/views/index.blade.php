@extends('layouts.app')

@section('content')
<div class="jumbotron m-0" id="main-slide">
    <div class="container text-white">
        <h1 class="display-4">Mining Equipment ASIC and GPU</h1>
        <p class="lead">P2P-platform for the sale of hardware and accessories for mining.</p>
        <hr class="my-4">
        <p>MAINTAINING THE BLOCKCHAIN WITH YOU!</p>
    </div>
</div>
<div class="bg-dark text-white py-3">
    <div class="container">
        <div class="row">
            @forelse ($prices as $price)
                <div class="col-sm-6 col-md-3 col-lg-2 text-center mb-2">
                    <span class="fs-5 fw-medium">
                        <img src="{{ asset('images/coins/'.$price->symbol.'.png') }}" class="img-fluid" style="max-height: 30px" alt="{{$price->symbol}}">
                        {{ round($price->lastPrice, 6) }}$
                    </span>
                    @if ($price->priceChangePercent > 0)
                        <div class="h6 mb-0 text-success">
                            ({{ round($price->priceChangePercent, 2) }}%)
                        </div>
                    @else
                        <div class="h6 mb-0 text-danger">
                            ({{ round($price->priceChangePercent, 2) }}%)
                        </div>
                    @endif
                </div>
            @empty
                
            @endforelse
        </div>
    </div>
</div>
<div class="container mt-4 mt-lg-5">
    <div class="row">
        <div class="col-md-4">
            <h2 class="text-center">World Wide</h2>
            <p>View ads of sellers from all over the world without any restrictions. We unite all people interested in the development of mining and cryptocurrencies.</p>
        </div>
        <div class="col-md-4">
            <h2 class="text-center">Free</h2>
            <p>Any user can offer their product to the community absolutely free of charge. This will help in achieving the overall goals of the blockchain architecture.</p>
        </div>
        <div class="col-md-4">
            <h2 class="text-center">Security</h2>
            <p>We ensure the security of any user data. It is planned to switch to the IPFS network for storing site data.</p>
        </div>
    </div>
</div>
@if($newest->count() > 1)
    <div class="container my-3">
        <h3>Popular</h3>
        <div class="row">
            @foreach($popular as $product)
            <div class="col-sm-12 col-md-6 col-lg-3 my-1">
                @include('partials.product_card_min')
            </div>
            @endforeach
        </div>
    </div>
@endif
@if($newest->count() > 1)
    <div class="container my-3">
        <h3>Newest</h3>
        <div class="row">
            @foreach($newest as $product)
            <div class="col-sm-12 col-md-6 col-lg-3 my-1">
                @include('partials.product_card_min')
            </div>
            @endforeach
        </div>
    </div>
@endif
<style>
    #main-slide {
        min-height: 550px;
        padding: 15px 0;
        background: 
		    linear-gradient(rgba(13, 47, 0, 0.7), rgba(1, 6, 0, 0.9)), 
		    url( {{ asset('images/pages/index-slide.jpg') }} ),
            no-repeat;
        background-size: cover;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: flex-end;
        border-radius: 0;
    }
</style>
@endsection
