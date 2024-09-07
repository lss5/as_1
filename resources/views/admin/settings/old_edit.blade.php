@extends('admin.layout')

@section('content_p')
<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <h1 class="h4 my-2">Editing setting</h1>
        <form action="{{ route('admin.settings.destroy', $setting) }}" method="POST" class="form-inline">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger" onclick='return confirm("Delete setting?");'>
                <i class="fas fa-trash"></i> Detete
            </button>
        </form>
        <hr class="py-1">
        <form method="POST" action="{{ route('admin.settings.update', $setting) }}">
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
                    <input name="name" value="{{ old('name') ?? $setting->name }}" type="text" class="form-control @error('name') is-invalid @enderror" id="name">
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
                    <input name="uniq_name" value="{{ old('uniq_name') ?? $setting->uniq_name }}" type="text" class="form-control @error('uniq_name') is-invalid @enderror" id="uniq_name">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="name">Value</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('value')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <input name="value" value="{{ old('value') ?? $setting->value }}" type="text" class="form-control @error('value') is-invalid @enderror" id="value">
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