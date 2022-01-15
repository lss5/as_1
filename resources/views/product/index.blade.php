@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">

        </div>
        @forelse ($products as $product)
        <div class="col-4 mt-2">
            @include('partials.product_card')
        </div>
        @endforeach
    </div>
</div>
@endsection
