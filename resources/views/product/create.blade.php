@extends('layouts.app')

@section('content')
    <div class="container shadow-sm bg-white rounded py-3">
        <h2>New listing</h2>
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
        <div class="row">
            <div class="col-sm-12 col-lg-3">
                <label for="image1" class="mb-0">Photos</label>
            </div>
            <div class="col-sm-12 col-lg-9 form-group">
                <div class="row">
                    <div class="col-12">
                        No product photos
                        <small class="form-text text-muted py-0 my-0">
                            You will be able to add product photos after create listing.
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf
            @include('product._form')
            <hr class="pb-1">
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-outline-success mx-1" role="button" aria-pressed="true">Create</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary mx-1" role="button" aria-pressed="false">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection