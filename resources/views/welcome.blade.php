@extends('layouts.app')

@section('content')
<div class="jumbotron">
    <div class="container">
        <h1 class="display-4">AsicSeller.com</h1>
        <p class="lead">P2P-platform for the sale of hardware and accessories for mining.</p>
        <hr class="my-4">
        <p>MAINTAINING THE BLOCKCHAIN WITH YOU!</p>
        <a class="btn btn-success btn-lg" href="{{ route('products.index') }}" role="button">Buy now!</a>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h2>World Wide</h2>
            <p>View ads of sellers from all over the world without any restrictions. We unite all people interested in the development of mining and cryptocurrencies.</p>
        </div>
        <div class="col-md-4">
            <h2>Free</h2>
            <p>Any user can offer their product to the community absolutely free of charge. This will help in achieving the overall goals of the blockchain architecture.</p>
        </div>
        <div class="col-md-4">
            <h2>Security</h2>
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
<hr class="pb-1">
@endsection
