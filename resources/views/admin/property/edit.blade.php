@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editing property {{ $property->title }}</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form method="POST" action="{{ route('admin.properties.update', $property) }}" class="w-100">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Categories</label>
                                    <select multiple class="form-control @error('categories') is-invalid @enderror" name="categories[]">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @if (in_array($category->id, $property_categories)) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('categories')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Type values</label>
                                    <select class="custom-select rounded-0 @error('value_type') is-invalid @enderror" name="value_type">
                                        @foreach ($value_types as $value_type)
                                            <option value="{{ $value_type }}" @if(old('value_type') == $value_type || $property->value_type == $value_type) selected @endif>{{ $value_type }}</option>
                                        @endforeach
                                    </select>
                                    @error('value_type')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputTitle">Title</label>
                                    <input type="text" id="inputTitle" name="title" class="form-control  @error('title') is-invalid @enderror" value="{{ old('title') ?? $property->title }}">
                                    @error('title')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputUnit">Unit of measurement</label>
                                    <input type="text" id="inputUnit" name="unit" class="form-control  @error('unit') is-invalid @enderror" value="{{ old('unit') ?? $property->unit }}">
                                    @error('unit')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputSort">Sort order</label>
                                    <input type="number" step="1" id="inputSort" name="sort" class="form-control  @error('sort') is-invalid @enderror" value="{{ old('sort') ?? $property->sort }}">
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
                        <a href="{{ route('admin.properties.index') }}" class="btn btn-secondary float-right">Cancel</a>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
