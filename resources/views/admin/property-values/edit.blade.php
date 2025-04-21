@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editing property value {{ $propertyValue->value }}</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form method="POST" action="{{ route('admin.property-values.update', $propertyValue) }}" class="w-100">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Type values</label>
                                    <select class="custom-select rounded-0 @error('property') is-invalid @enderror" name="property">
                                        @foreach ($properties as $property)
                                            <option value="{{ $property->id }}" @if(old('property') == $property->id || $property->id == $propertyValue->property_id) selected @endif>{{ $property->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('property')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputValue">Value</label>
                                    <input type="text" id="inputValue" name="value" class="form-control  @error('value') is-invalid @enderror" value="{{ old('value') ?? $propertyValue->value }}">
                                    @error('value')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputSort">Sort order</label>
                                    <input type="number" step="1" id="inputSort" name="sort" class="form-control  @error('sort') is-invalid @enderror" value="{{ old('sort') ?? $propertyValue->sort }}">
                                    @error('sort')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <input type="submit" value="Save" class="btn btn-success">
                        <a href="{{ route('admin.property-values.index') }}" class="btn btn-secondary float-right">Cancel</a>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
