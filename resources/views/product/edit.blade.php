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
        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('product._form')
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-outline-success mr-2" role="button" aria-pressed="true">Update</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary mr-2" role="button" aria-pressed="false">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection