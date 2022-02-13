@extends('layouts.app')

@section('content')
    <div class="container shadow-sm bg-white rounded py-3">
        <h2>Edit listing</h2>
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
                @if ($product->images->count() > 0)
                    <div class="row">
                        @foreach ($product->images as $image)
                            <div class="col-sm-12 col-lg-4 mb-2">
                                <img src="{{ asset('storage/'.$image->link) }}" class="img-thumbnail" alt="...">
                                <small class="form-text text-muted">
                                    <td>{{ date('d-m-Y H:i:s', strtotime($image->created_at)) }}</td>
                                </small>
                                <form method="POST" action="{{ route('images.destroy', $image) }}">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" onclick='return confirm("Delete photo?");' role="button" aria-pressed="true" class="btn btn-outline-danger btn-sm my-1">Delete</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
                @if ($product_images < 3)
                    <div class="row">
                        <div class="col-sm-12">
                            <form method="POST" action="{{ route('products.addimage', $product) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-success @error('image') is-invalid @enderror" type="submit" id="image-file-button">Upload <i class="fas fa-file-upload"></i></button>
                                    </div>
                                    <div class="custom-file">
                                        <input name="image" id="image" type="file" class="custom-file-input @error('image') is-invalid @enderror" aria-describedby="image-file-button">
                                        <label class="custom-file-label" for="image" aria-describedby="inputGroupFileAddon02">Choose file</label>
                                    </div>
                                </div>
                            </form>
                            <small id="imageHelp" class="form-text text-muted">Select a photo and click upload, a 16:10 aspect ratio is recommended.</small>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('product._form')
            <hr class="pb-1">
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-outline-success mr-2" role="button" aria-pressed="true">Save</button>
                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-secondary mr-2" role="button" aria-pressed="false">Back</a>
                </div>
            </div>
        </form>
    </div>
@endsection