@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Creating new category</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form method="POST" action="{{ route('admin.categories.store') }}" class="w-100">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputName">Name</label>
                                    <input type="text" id="inputName" name="name" class="form-control  @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputSort">Sort order</label>
                                    <input type="number" step="1" id="inputSort" name="sort" class="form-control  @error('sort') is-invalid @enderror" value="{{ old('sort') }}">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input id="inputTopMenu" name="top_menu" value="1" type="checkbox" class="custom-control-input">
                                        <label class="custom-control-label" for="inputTopMenu">Top menu</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Properties for Products</label>
                                    <select multiple class="form-control @error('properties') is-invalid @enderror" name="properties[]">
                                        @foreach ($properties as $property)
                                            <option value="{{ $property->id }}" @if (in_array($property->id, old('properties') ?? [])) selected @endif>{{ $property->title .', '. $property->unit }}</option>
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
                        <input type="submit" value="Create" class="btn btn-success">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary float-right">Cancel</a>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
