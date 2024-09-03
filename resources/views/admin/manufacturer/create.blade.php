@extends('admin.layout')

@section('content_p')
<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <h1 class="h4 my-2">Creating manufacturer</h1>
        <hr class="py-1">
        <form method="POST" action="{{ route('admin.manufacturers.store') }}">
            @csrf
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="name">Name</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('name')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <input name="name" value="{{ old('name') }}" type="text" class="form-control @error('name') is-invalid @enderror" id="name">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="url">Web site</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('url')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <input name="url" value="{{ old('url') }}" type="text" class="form-control @error('url') is-invalid @enderror" id="url">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="description">Description</label>
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
                    <label for="sort">Sort order</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('sort')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <input id="sort" name="sort" step="1" value="{{ old('sort') }}" type="number" class="form-control @error('sort') is-invalid @enderror">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="country_id">{{ __('product.country.title') }}</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('country_id')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <select name="country_id" id="country_id" class="custom-select @error('country_id') is-invalid @enderror" aria-describedby="countryHelp">
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" @if(old('country_id') == $country->id) selected @endif>{{ $country->name }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">{{__('product.country.prompt')}}</small>
                </div>
            </div>

            <hr class="pb-1">
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-outline-success mx-1" role="button" aria-pressed="true">Create</button>
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary mx-1" role="button" aria-pressed="false">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection