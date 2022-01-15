@extends('layouts.app')

@section('content')
<div class="container shadow-sm bg-white rounded py-3">
    <div class="row">
        <div class="col-md-3">
            <h3>{{ Auth::user()->name }}</h3>
            <a class="" href="{{ route('products.index') }}">Listings</a>
            <hr>
            <a class="" href="{{ route('products.index') }}">Settings</a>
        </div>
        <div class="col-md-6"></div>
    </div>
</div>
@endsection
