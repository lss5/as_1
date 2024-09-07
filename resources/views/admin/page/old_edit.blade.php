@extends('admin.layout')

@section('script')
<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>
    const example_image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', 'postAcceptor.php');
        xhr.open('POST', '{{ route("admin.pages.image_upload") }}');
        var token = '{{ csrf_token() }}';
        xhr.setRequestHeader("X-CSRF-Token", token);

        xhr.upload.onprogress = (e) => {
            progress(e.loaded / e.total * 100);
        };

        xhr.onload = () => {
            if (xhr.status === 403) {
            reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
            return;
            }

            if (xhr.status < 200 || xhr.status >= 300) {
            reject('HTTP Error: ' + xhr.status);
            return;
            }

            const json = JSON.parse(xhr.responseText);

            if (!json || typeof json.location != 'string') {
            reject('Invalid JSON: ' + xhr.responseText);
            return;
            }

            resolve(json.location);
        };

        xhr.onerror = () => {
            reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
        };

        const formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        xhr.send(formData);
    });

    tinymce.init({
        selector: 'textarea#content',
        statusbar: false,
        plugins: 'code lists link image emoticons',
        toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | bullist numlist | emoticons image',
        images_upload_handler: example_image_upload_handler,
        image_title: true,
        file_picker_types: 'image',
    });
</script>
@endsection

@section('content_p')
<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <h1 class="h4 my-2">Edititng page</h1>
        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="form-inline">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger" onclick='return confirm("Delete all messages?");'>
                <i class="fas fa-trash"></i> Detete
            </button>
        </form>
        <hr class="py-1">
        <form method="POST" action="{{ route('admin.pages.update', $page) }}" enctype="multipart/form-data">
            @method('PUT')
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
                            <option value="{{ $section->id }}" @if(old('section') == $section->id || $page->section->id == $section->id) selected @endif>{{ $section->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <label for="sort">Sort order</label>
                </div>
                <div class="col-sm-12 col-lg-9 form-group">
                    @error('sort')
                        <small class="form-text text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <input id="sort" name="sort" step="1" value="{{ old('sort') ?? $page->sort }}" type="number" class="form-control @error('sort') is-invalid @enderror">
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
                    <input name="name" value="{{ old('name') ?? $page->name }}" type="text" class="form-control @error('name') is-invalid @enderror" id="name">
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
                    <input name="list_name" value="{{ old('list_name') ?? $page->list_name }}" type="text" class="form-control @error('list_name') is-invalid @enderror" id="list_name">
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
                    <input name="uniq_name" value="{{ old('uniq_name') ?? $page->uniq_name }}" type="text" class="form-control @error('uniq_name') is-invalid @enderror" id="uniq_name">
                </div>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" class="form-control @error('content') is-invalid @enderror" id="content" rows="5">{{ old('content') ?? $page->content }}</textarea>
                @error('content')
                    <small class="form-text text-danger">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <hr class="pb-1">
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-outline-success mx-1" role="button" aria-pressed="true">Update</button>
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary mx-1" role="button" aria-pressed="false">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection