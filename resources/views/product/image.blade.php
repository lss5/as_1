@extends('layouts.app')

@section('content')
    <div class="container shadow-sm bg-white rounded py-3">
        <h3>Edit photos for product</h3>
        <h4>{{ $product->title }}</h4>
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
            @isset($product->images)
                @foreach ($product->images as $image)
                    <div class="col-sm-12 col-lg-4">
                        <img src="{{ asset('storage/'.$image->link) }}" class="img-thumbnail" alt="...">
                        <small class="form-text text-muted">
                            <td>Date upload: {{ date('d-m-Y H:i:s', strtotime($image->created_at)) }}</td>
                        </small>
                        <form method="POST" action="{{ route('images.destroy', $image) }}">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm my-1" role="button" aria-pressed="true">Delete</button>
                        </form>
                    </div>
                @endforeach
            @endisset
            @if ($product_images < 3)
                <div class="col-sm-12 my-2">
                    <form method="POST" action="{{ route('products.addimage', $product) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input name="image" type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" aria-describedby="image-button">
                                <label class="custom-file-label" for="image" aria-describedby="image">Choose file</label>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" id="image-button">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
            @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <hr class="py-1">
        <div class="row">
            <a href="{{ route('products.edit', $product) }}" type="button" class="btn btn-outline-success mx-2">Back</a>
        </div>
    </div>
@endsection