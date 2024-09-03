@extends('layouts.profile')

@section('content')
<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <h1 class="h4 my-2">{{ __('product.pages.new') }}</h1>
        <hr class="py-1">
        <form method="POST" action="{{ route('profile.listing.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label class="mb-0">{{ __('product.image.title') }}</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    <div class="row">
                        <div class="col-sm-12">
                            @error('status')
                                <small class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                            @error('image')
                                <small class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="image" id="image" type="file" class="custom-file-input @error('image') is-invalid @enderror">
                                    <label class="custom-file-label" for="image">Choose file</label>
                                </div>
                            </div>
                            <small class="form-text text-muted">{{ __('product.image.prompt') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="manufacturer">Manufacturer</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('manufacturer')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <select class="custom-select @error('manufacturer') is-invalid @enderror" aria-describedby="manufacturerHelp" name="manufacturer" id="manufacturer">
                        @foreach ($manufacturers as $manufacturer)
                            <option value="{{ $manufacturer->id }}" @if(old('country') == $manufacturer->id) selected @endif>{{ $manufacturer->name }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Manufacturer your hardware</small>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="category">{{ __('product.category.title') }}</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('category')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <select name="category" id="category" class="custom-select @error('category') is-invalid @enderror" aria-describedby="categoryHelp">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if(old('category') == $category->id || $categories['0']->id == $category->id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="condition">{{ __('product.isnew.title') }}</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    <div class="custom-control custom-switch">
                        <input id="condition" name="condition" type="checkbox" class="custom-control-input">
                        <label class="custom-control-label" for="condition">{{ __('product.isnew.prompt') }}</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="title">{{ __('product.title.title') }}</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('title')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <input name="title" value="{{ old('title') }}" type="text" class="form-control @error('title') is-invalid @enderror" id="title" aria-describedby="titleHelp">
                    <small class="form-text text-muted">{{ __('product.title.prompt') }}</small>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="description">{{ __('product.description.title') }}</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('description')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="5">{{ old('description') }}</textarea>
                    <small class="form-text text-muted">{{ __('product.description.prompt') }}</small>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="price">{{ __('product.price.title') }}</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('price')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <input id="price" name="price" step="1" value="{{ old('price') }}" type="number" aria-describedby="priceHelp" class="form-control @error('price') is-invalid @enderror">
                    <small class="form-text text-muted">{{ __('product.price.prompt') }}</small>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="quantity">{{ __('product.quantity.title') }}</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('quantity')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <input id="quantity" name="quantity" step="1" value="{{ old('quantity') }}" type="number" aria-describedby="quantityHelp" class="form-control @error('quantity') is-invalid @enderror">
                    <small class="form-text text-muted">{{ __('product.quantity.prompt') }}</small>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="moq">{{ __('product.moq.title') }}</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('moq')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <input id="moq" name="moq" step="1" value="{{ old('moq') }}" type="number" aria-describedby="moqHelp" class="form-control @error('moq') is-invalid @enderror">
                    <small class="form-text text-muted">{{ __('product.moq.prompt') }}</small>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="power">{{ __('product.power.title') }}</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('power')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <input id="power" name="power" step="1" value="{{ old('power') }}" type="number" aria-describedby="powerHelp" class="form-control @error('power') is-invalid @enderror">
                    <small class="form-text text-muted">{{ __('product.power.prompt') }}</small>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="algorithm">{{ __('product.algorithm.title') }}</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('algorithm')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <select name="algorithm" id="algorithm" class="custom-select @error('algorithm') is-invalid @enderror" aria-describedby="algorithmHelp">
                        @foreach (App\Product::$algorithms as $alg => $hrt)
                            <option value="{{ $alg }}" @if(old('algorithm') == $alg) selected @endif>{{ __('product.algorithms.'.$alg) }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">{{__('product.algorithm.prompt')}}</small>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="hashrate">{{ __('product.hashrate.title') }}</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="hashrate" id="hashrate" value="{{ old('hashrate') }}" class="form-control @error('hashrate') is-invalid @enderror" aria-label="Hashrate" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <select class="custom-select @error('hashrateName') is-invalid @enderror" name="hashrateName" id="hashrateName">
                                @foreach (App\Product::$hashrates as $uniq => $name)
                                    <option @if(old('hashrateName') == $uniq) selected @endif value="{{ $uniq }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('hashrate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        @error('hashrateName')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="country">{{ __('product.country.title') }}</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('country')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <select class="custom-select @error('country') is-invalid @enderror" aria-describedby="countryHelp" name="country" id="country">
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" @if(old('country') == $country->id || $country->id == Auth::user()->country_id) selected @endif>{{ $country->name }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">{{__('product.country.prompt')}}</small>
                </div>
            </div>

            <hr class="pb-1">
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-outline-success mx-1" role="button" aria-pressed="true">{{ __('product.btn.create') }}</button>
                    <a href="{{ route('profile.listing.index') }}" class="btn btn-outline-secondary mx-1" role="button" aria-pressed="false">{{ __('product.btn.cancel') }}</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection