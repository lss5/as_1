@extends('home.layout')

@section('content_p')
<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <div class="d-flex flex-row justify-content-between">
            <h1 class="h4 my-2">{{ __('product.pages.edit') }}</h1>
            <form action="{{ route('products.destroy', $product) }}" method="POST" class="form-inline">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger" onclick='return confirm("Delete item?");'>
                    Delete <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
        <hr class="py-1 my-2">
        <div class="row">
            <div class="col-sm-12 col-lg-3">
                <label class="mb-0">{{ __('product.image.title') }}</label>
            </div>
            <div class="col-sm-12 col-lg-9 form-group">
                <div class="row">
                    @foreach ($product->images as $image)
                        <div class="col-sm-12 col-lg-4 mb-2">
                            <img src="{{ asset('storage/'.$image->link) }}" class="img-thumbnail" alt="...">
                            <small class="form-text text-muted">
                                <td>{{ date('d-m-Y H:i:s', strtotime($image->created_at)) }}</td>
                            </small>
                            <form method="POST" action="{{ route('products.images.destroy', $image) }}">
                                @method('DELETE')
                                @csrf
                                <button type="submit" onclick='return confirm("Delete photo?");' role="button" aria-pressed="true" class="btn btn-outline-danger btn-sm my-1">{{ __('product.btn.delete') }}</button>
                            </form>
                        </div>
                    @endforeach
                </div>
                @if ($product_images < 3)
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
                            <small id="imageHelp" class="form-text text-muted">{{ __('product.image.prompt') }}</small>
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
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="category">{{ __('product.category.title') }}</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('category')
                        <span class="form-text text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <select name="category" id="category" class="custom-select @error('category') is-invalid @enderror" aria-describedby="categoryHelp">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if(old('category') == $category->id || $product->categories->pluck('id')->first() == $category->id) selected @endif>{{ $category->name }}</option>
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
                        <input id="condition" name="condition" type="checkbox" class="custom-control-input"
                        @if ($product->exists)
                            @if (old('condition') ?? $product->isnew == 1) checked="checked" @endif
                        @endif>
                        <label class="custom-control-label" for="condition">Brand new</label>
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
                    <input name="title" value="{{ old('title') ?? $product->title }}" type="text" class="form-control @error('title') is-invalid @enderror" id="title" aria-describedby="titleHelp">
                    <small class="form-text text-muted">{{ __('product.title.prompt') }}</small>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="description">{{ __('product.description.title') }}</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="5">{{ old('description') ?? $product->description }}</textarea>
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
                    <input id="price" name="price" step="1" value="{{ old('price') ?? $product->price }}" type="number" aria-describedby="priceHelp" class="form-control @error('price') is-invalid @enderror">
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
                    <input id="quantity" name="quantity" step="1" value="{{ old('quantity') ?? $product->quantity }}" type="number" aria-describedby="quantityHelp" class="form-control @error('quantity') is-invalid @enderror">
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
                    <input id="moq" name="moq" step="1" value="{{ old('moq') ?? $product->moq }}" type="number" aria-describedby="moqHelp" class="form-control @error('moq') is-invalid @enderror">
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
                    <input id="power" name="power" step="1" value="{{ old('power') ?? $product->power }}" type="number" aria-describedby="powerHelp" class="form-control @error('power') is-invalid @enderror">
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
                            <option value="{{ $alg }}" @if(old('algorithm') == $alg || $product->algorithm == $alg) selected @endif>{{ __('product.algorithms.'.$alg) }}</option>
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
                        <input type="text" name="hashrate" id="hashrate" value="{{ old('hashrate') ?? $product->hashrate }}" class="form-control @error('hashrate') is-invalid @enderror" aria-label="Hashrate" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <select class="custom-select @error('hashrateName') is-invalid @enderror" name="hashrateName" id="hashrateName">
                                @foreach (App\Product::$hashrates as $uniq => $name)
                                    <option @if(old('hashrateName') == $uniq || $product->hashrate_name == $uniq) selected @endif value="{{ $uniq }}">{{ $name }}</option>
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
                    <select class="custom-select @error('country') is-invalid @enderror" aria-describedby="countryHelp" name="country" id="country">
                        @foreach ($countries as $country)
                            @if($product->exists)
                                <option value="{{ $country->id }}" @if(old('country') == $country->id || $product->country_id == $country->id) selected @endif>{{ $country->name }}</option>
                            @else
                                <option value="{{ $country->id }}" @if(old('country') == $country->id || $country->id == Auth::user()->country_id) selected @endif>{{ $country->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <small class="form-text text-muted">{{__('product.country.prompt')}}</small>
                    @error('country')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            
            <hr class="pb-1">
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-outline-success mr-2" role="button" aria-pressed="true">{{ __('product.btn.save') }}</button>
                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-secondary mr-2" role="button" aria-pressed="false">{{ __('product.btn.back') }}</a>
                </div>
            </div>
        </form>
    </div>
@endsection