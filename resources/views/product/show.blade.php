@extends('layouts.app')

@section('content')
    <div class="container shadow-sm bg-white rounded py-3">
        <h2>{{ $product->title }}</h2>
        <div class="row">
            <div class="col-6"></div>
            <div class="col-6" style="min-height: 400px;"></div>
            <div class="col-12">{{ $product->description }}</div>
        </div>
        
    </div>
@endsection