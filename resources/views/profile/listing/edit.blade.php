@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editing listing</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form method="POST" action="{{ route('profile.listings.update', $listing) }}" class="w-100" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    @if ($listing->images->count() > 0)
                                        <img class="profile-user-img border-1" src="{{ asset('storage/'.$listing->images->first()->link) }}">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="inputImage">Photo</label>
                                    <input type="file" id="inputImage" name="image" class="form-control-file  @error('image') is-invalid @enderror">
                                    @error('image')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" @if (old('condition') ?? $listing->is_new == 1) checked="checked" @endif name="condition" id="checkboxCondition">
                                        <label class="custom-control-label" for="checkboxCondition">New product (not used)</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="selectProduct">Product</label>
                                    <select class="custom-select rounded-0 @error('product_id') is-invalid @enderror" name="product" id="selectProduct">
                                        <option @empty(old('product')) selected @endempty>Please select</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" @if(old('product') == $product->id || $listing->product->id == $product->id) selected @endif>{{ $product->manufacturer->name . ' ' . $product->model }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputQuantity">Quantity</label>
                                    <input type="number" step="1" min="1" id="inputQuantity" name="quantity" value="{{ old('quantity') ?? $listing->quantity }}" class="form-control @error('quantity') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="inputMoq">Minimum order quantity</label>
                                    <input type="number" step="1" min="1" id="inputMoq" name="moq" value="{{ old('moq') ?? $listing->moq }}" class="form-control @error('moq') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="inputPrice">Price</label>
                                    <input type="number" step="1" min="1" id="inputPrice" name="price" value="{{ old('price') ?? $listing->price }}" class="form-control @error('price') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="inputSerialNumber">Serial Number</label>
                                    <input type="text" id="inputSerialNumber" name="serial_number" value="{{ old('serial_number') ?? $listing->serial_number }}" class="form-control @error('serial_number') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="selectContry">Location of product</label>
                                    <select class="custom-select rounded-0 @error('country_id') is-invalid @enderror" name="country" id="selectContry">
                                        <option @empty(old('country')) selected @endempty>Please select</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" @if(old('country') == $country->id || $listing->country->id == $country->id) selected @endif>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" rows="4" name="description" placeholder="Enter ...">{{ old('description') ?? $listing->description }}</textarea>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <a href="{{ route('profile.listings.active') }}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Save" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
