@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editing algorithm {{ $property->name }}</h1>
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
                                    <label for="inputTitle">Title</label>
                                    <input type="text" id="inputTitle" name="title" class="form-control  @error('title') is-invalid @enderror" value="{{ old('title') ?? $property->title }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputUnit">Unit of measurement</label>
                                    <input type="text" id="inputUnit" name="unit" class="form-control  @error('unit') is-invalid @enderror" value="{{ old('unit') ?? $property->unit }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputSort">Sort order</label>
                                    <input type="number" step="1" id="inputSort" name="sort" class="form-control  @error('sort') is-invalid @enderror" value="{{ old('sort') ?? $property->sort }}">
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
