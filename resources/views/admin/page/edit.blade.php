@extends('layouts.admin')

@section('script')
<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>
    const example_image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', 'postAcceptor.php');
        // xhr.open('POST', '{{ route("admin.pages.image_upload") }}');
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

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit {{ $page->name }}</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <form method="POST" action="{{ route('admin.pages.update', $page) }}" enctype="multipart/form-data" class="w-100">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="selectSection">Section</label>
                                    <select class="custom-select rounded-0 @error('section_id') is-invalid @enderror" name="section_id" id="selectSection">
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}" @if(old('section') == $section->id || $page->section_id == $section->id) selected @endif>{{ $section->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputName">Name</label>
                                    <input type="text" id="inputName" name="name" class="form-control  @error('name') is-invalid @enderror" value="{{ old('name') ?? $page->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputSort">Sort order</label>
                                    <input type="number" step="1" id="inputSort" name="sort" class="form-control  @error('sort') is-invalid @enderror" value="{{ old('sort') ?? $page->sort }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputListName">List name</label>
                                    <input type="text" id="inputListName" name="list_name" class="form-control  @error('list_name') is-invalid @enderror" value="{{ old('list_name') ?? $page->list_name }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputUniqName">Unique Name</label>
                                    <input type="text" id="inputUniqName" name="uniq_name" class="form-control  @error('uniq_name') is-invalid @enderror" value="{{ old('uniq_name') ?? $page->uniq_name }}">
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Save" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
