@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Request for company registration</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form method="POST" action="{{ route('profile.companies.store') }}" class="w-100" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputImageLogo">Logo image</label>
                                    <input type="file" id="inputImageLogo" name="image_logo" class="form-control-file  @error('image_logo') is-invalid @enderror">
                                    <small id="inputImageLogoHelp" class="form-text text-muted">Min. width/height: 256px, Max. size 2048kb</small>
                                    @error('image')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputImageHeader">Header image</label>
                                    <input type="file" id="inputImageHeader" name="image_header" class="form-control-file  @error('image_header') is-invalid @enderror">
                                    <small id="inputImageHeaderHelp" class="form-text text-muted">We recommend using the size 1024*256px (4:1). Max. size 4096kb</small>
                                    @error('image')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" checked name="condition" id="checkboxCondition">
                                        <label class="custom-control-label" for="checkboxCondition">New product (not used)</label>
                                    </div>
                                </div> --}}
                                {{-- <div class="form-group">
                                    <label for="selectProduct">Product</label>
                                    <select class="custom-select rounded-0 @error('product_id') is-invalid @enderror" name="product" id="selectProduct">
                                        <option @empty(old('product')) selected @endempty>Please select</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" @if(old('product') == $product->id) selected @endif>{{ $product->manufacturer->name . ' ' . $product->model }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" rows="4" name="description" placeholder="About your company"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="inputLegalAddress">Legal Address</label>
                                    <input type="text" id="inputLegalAddress" name="legal_address" value="{{ old('legal_address') }}" class="form-control @error('legal_address') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="inputActualAddress">Actual Address</label>
                                    <input type="text" id="inputActualAddress" name="actual_address" value="{{ old('actual_address') }}" class="form-control @error('actual_address') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="selectContry">Location of company</label>
                                    <select class="custom-select rounded-0 @error('country_id') is-invalid @enderror" name="country" id="selectContry">
                                        <option @empty(old('country')) selected @endempty>Please select</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" @if(old('country') == $country->id) selected @endif>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <input type="submit" value="Create request" class="btn btn-success">
                        <a href="{{ route('profile.index') }}" class="btn btn-secondary float-right">Cancel</a>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
