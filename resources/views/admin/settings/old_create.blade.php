@extends('admin.layout')

@section('content_p')
<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <h1 class="h4 my-2">Creating setting</h1>
        <hr class="py-1">
        <form method="POST" action="{{ route('admin.settings.store') }}">
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
                    <label for="uniq_name">Uniq name</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('uniq_name')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <input name="uniq_name" value="{{ old('uniq_name') }}" type="text" class="form-control @error('uniq_name') is-invalid @enderror" id="uniq_name">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="uniq_name">Value</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('value')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <input name="value" value="{{ old('value') }}" type="text" class="form-control @error('value') is-invalid @enderror" id="value">
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