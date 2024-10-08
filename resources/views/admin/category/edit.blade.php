@extends('admin.layout')

@section('content_p')
<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <h1 class="h4 my-2">Editing category</h1>
        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="form-inline">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger" onclick='return confirm("Delete all messages?");'>
                <i class="fas fa-trash"></i> Detete
            </button>
        </form>
        <hr class="py-1">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
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
                    <input name="name" value="{{ old('name') ?? $category->name }}" type="text" class="form-control @error('name') is-invalid @enderror" id="name">
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
                    <input name="uniq_name" value="{{ old('uniq_name') ?? $category->uniq_name }}" type="text" class="form-control @error('uniq_name') is-invalid @enderror" id="uniq_name">
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
                    <input id="sort" name="sort" step="1" value="{{ old('sort') ?? $category->sort }}" type="number" class="form-control @error('sort') is-invalid @enderror">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="top_menu">Top menu</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    <div class="custom-control custom-switch">
                        <input id="top_menu" name="top_menu" type="checkbox" class="custom-control-input"
                        @if ($category->exists)
                            @if (old('top_menu') ?? $category->top_menu == 1) checked="checked" @endif
                        @endif>
                        <label class="custom-control-label" for="top_menu">Top menu</label>
                    </div>
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