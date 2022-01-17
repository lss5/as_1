<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="title">Your product title</label>
    </div>
    <div class="col-sm-12 col-lg-9">
        <input name="title" value="{{ $product->title ?? old('title') }}" type="text" class="form-control @error('title') is-invalid @enderror" id="title" aria-describedby="titleHelp" placeholder="model or name">
        <small id="titleHelp" class="form-text text-muted">max: 255</small>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="description">Your product description</label>
    </div>
    <div class="col-sm-12 col-lg-9">
        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="5">{{ $product->description ?? old('description') }}</textarea>
        <small id="descriptionHelp" class="form-text text-muted">Only true information</small>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="image1">Your product image</label>
    </div>
    <div class="col-sm-12 col-lg-9">
        <div class="row">
        @isset($product->images)
            @foreach ($product->images as $image)
                <div class="col-sm-12 col-lg-4">
                    <img src="{{ asset('storage/'.$image->link) }}" class="img-thumbnail" alt="...">
                    <small class="form-text text-muted">
                        <td>{{ date('d-m-Y H:i:s', strtotime($image->created_at)) }}</td>
                    </small>
                    {{-- <form method="POST" action="{{ route('images.destroy', $image) }}">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm mr-2" role="button" aria-pressed="true">Delete</button>
                    </form> --}}
                </div>
            @endforeach
        @endisset
        @for ($i = $product_images; $i < 3; $i++)
            <div class="col-sm-12 col-lg-4">
                <input type="file" name="image{{$i}}" id="image{{$i}}" class="@error('image{{$i}}') is-invalid @enderror">
                @error('image{{$i}}')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        @endfor
        </div>
    </div>
</div>