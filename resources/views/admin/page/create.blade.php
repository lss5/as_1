@extends('admin.layout')

@section('script')
<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
 <script>
   tinymce.init({
     selector: 'textarea#content',
     plugins: 'code lists',
     toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code'
   });
 </script>
@endsection

@section('content_p')
<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <h1 class="h4 my-2">Creating page</h1>
        <hr class="py-1">
        <form method="POST" action="{{ route('admin.pages.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="section_id">Section</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('section_id')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <select name="section_id" id="section_id" class="custom-select @error('section_id') is-invalid @enderror" aria-describedby="section_idHelp">
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}" @if(old('section') == $section->id) selected @endif>{{ $section->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
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
                    <label for="list_name">List name</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('list_name')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <input name="list_name" value="{{ old('list_name') }}" type="text" class="form-control @error('list_name') is-invalid @enderror" id="list_name">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="uniq_name">Unique name</label>
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
                    <label for="content">Content</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('content')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" id="content" rows="5">{{ old('content') }}</textarea>
                </div>
            </div>

            <hr class="pb-1">
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-outline-success mx-1" role="button" aria-pressed="true">Create</button>
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary mx-1" role="button" aria-pressed="false">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection