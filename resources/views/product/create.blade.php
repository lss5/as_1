@extends('layouts.app')

@section('content')
    <div class="container shadow-sm bg-white rounded py-3">
        <h2>New sale</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <hr class="pb-1">
        <form method="POST" action="{{ route('products.store') }}">
            @csrf
            @include('product._form')
        </form>
    </div>
@endsection