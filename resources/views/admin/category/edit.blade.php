@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editing category {{ $category->name }}</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="w-100">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputName">Name</label>
                                    <input type="text" id="inputName" name="name" class="form-control  @error('name') is-invalid @enderror" value="{{ old('name') ?? $category->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputSort">Sort order</label>
                                    <input type="number" step="1" id="inputSort" name="sort" class="form-control  @error('sort') is-invalid @enderror" value="{{ old('sort') ?? $category->sort }}">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input id="top_menu" name="top_menu" type="checkbox" class="custom-control-input"
                                        @if ($category->exists)
                                            @if (old('top_menu') ?? $category->top_menu == 1) checked="checked" @endif
                                        @endif>
                                        <label class="custom-control-label" for="top_menu">Top menu</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Properties for Products</label>
                                    <select multiple class="form-control @error('properties') is-invalid @enderror" name="properties[]">
                                        @foreach ($properties as $property)
                                            <option value="{{ $property->id }}" @if (in_array($property->id, $category_properties)) selected @endif>{{ $property->title .', '. $property->unit}}</option>
                                        @endforeach
                                    </select>
                                    @error('properties')
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
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary float-right">Cancel</a>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
