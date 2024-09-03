@extends('admin.layout')

@section('content_p')
<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <h1 class="h4 my-2">Editing manufacturer</h1>
        <form action="{{ route('admin.manufacturers.destroy', $manufacturer) }}" method="POST" class="form-inline">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger" onclick='return confirm("Delete all messages?");'>
                <i class="fas fa-trash"></i> Detete
            </button>
        </form>
        <hr class="py-1">
        <form method="POST" action="{{ route('admin.manufacturers.update', $manufacturer) }}">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="section">Name</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('name')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <input name="name" value="{{ old('name') ?? $manufacturer->name }}" type="text" class="form-control @error('name') is-invalid @enderror" id="name">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="name">Uniq name</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('uniq_name')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <input name="uniq_name" value="{{ old('uniq_name') ?? $manufacturer->uniq_name }}" type="text" class="form-control @error('uniq_name') is-invalid @enderror" id="uniq_name">
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
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="5">{{ old('description') ?? $manufacturer->description }}</textarea>
                    <small class="form-text text-muted">{{ __('product.description.prompt') }}</small>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="name">Sort order</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('sort')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <input id="sort" name="sort" step="1" value="{{ old('sort') ?? $manufacturer->sort }}" type="number" class="form-control @error('sort') is-invalid @enderror">
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
                            @if($manufacturer->exists)
                                <option value="{{ $country->id }}" @if(old('country_id') == $country->id || $manufacturer->country_id == $country->id) selected @endif>{{ $country->name }}</option>
                            @else
                                <option value="{{ $country->id }}" @if(old('country_id') == $country->id || $country->id == Auth::user()->country_id) selected @endif>{{ $country->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <small class="form-text text-muted">{{__('product.country.prompt')}}</small>
                </div>
            </div>

            <hr class="pb-1">
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-outline-success mx-1" role="button" aria-pressed="true">Update</button>
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary mx-1" role="button" aria-pressed="false">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection