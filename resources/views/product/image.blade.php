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
                            <button type="submit" onclick='return confirm("Delete photo?");' role="button" aria-pressed="true" class="btn btn-outline-danger btn-sm my-1">Delete</button>
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
                            <div class="input-group-prepend">
                              <button class="btn btn-outline-success" type="submit" id="image-file-button">Upload image</button>
                            </div>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input @error('image') is-invalid @enderror" name="image" id="input-file" aria-describedby="image-file-button">
                              <label class="custom-file-label" for="input-file">Choose file</label>
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
            <div class="col-12">
                <a href="{{ route('products.edit', $product) }}" type="button" class="btn btn-outline-secondary mx-1">Edit</a>
                <a href="{{ route('products.show', $product) }}" type="button" class="btn btn-outline-secondary mx-1">Show</a>
            </div>
        </div>
    </div>
@endsection