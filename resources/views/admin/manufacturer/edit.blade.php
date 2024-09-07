@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editing {{ $manufacturer->name }}</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form method="POST" action="{{ route('admin.manufacturers.update', $manufacturer) }}" class="w-100">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputName">Name</label>
                                    <input type="text" id="inputName" name="name" class="form-control  @error('name') is-invalid @enderror" value="{{ old('name') ?? $manufacturer->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputUrl">Web site</label>
                                    <input type="text" id="inputUrl" name="url" class="form-control  @error('url') is-invalid @enderror" value="{{ old('url') ?? $manufacturer->url }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputSort">Sort order</label>
                                    <input type="number" step="1" id="inputSort" name="sort" class="form-control  @error('sort') is-invalid @enderror" value="{{ old('sort') ?? $manufacturer->sort }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputContent">Description</label>
                                    <textarea name="description" id="inputContent" class="form-control @error('description') is-invalid @enderror" rows="5">{{ old('description') ?? $manufacturer->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="selectContry">Country</label>
                                    <select class="custom-select rounded-0 @error('country_id') is-invalid @enderror" name="country_id" id="selectContry">
                                        <option @empty(old('country_id')) selected @endempty>Please select</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" @if(old('country_id') == $country->id || $manufacturer->country_id == $country->id ) selected @endif>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <a href="{{ route('admin.manufacturers.index') }}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Save" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
