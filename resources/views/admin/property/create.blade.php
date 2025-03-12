@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Creating new property</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form method="POST" action="{{ route('admin.properties.store') }}" class="w-100">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputTitle">Title</label>
                                    <input type="text" id="inputTitle" name="title" class="form-control  @error('title') is-invalid @enderror" value="{{ old('title') }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputUnit">Unit of measurement</label>
                                    <input type="text" id="inputUnit" name="unit" class="form-control  @error('unit') is-invalid @enderror" value="{{ old('unit') }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputSort">Sort order</label>
                                    <input type="number" step="1" id="inputSort" name="sort" class="form-control  @error('sort') is-invalid @enderror" value="{{ old('sort') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <a href="{{ route('admin.properties.index') }}" class="btn btn-secondary float-right">Cancel</a>
                        <input type="submit" value="Create" class="btn btn-success">
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
