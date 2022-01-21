<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="title">Your product title</label>
    </div>
    <div class="col-sm-12 col-lg-9 form-group">
        <input name="title" value="{{ $product->title ?? old('title') }}" type="text" class="form-control @error('title') is-invalid @enderror" id="title" aria-describedby="titleHelp" placeholder="model or name">
        <small id="titleHelp" class="form-text text-muted">max: 255</small>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="description">Your product description</label>
    </div>
    <div class="col-sm-12 col-lg-9 form-group">
        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="5">{{ $product->description ?? old('description') }}</textarea>
        <small id="descriptionHelp" class="form-text text-muted">Max:4096</small>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="price">Price, USD</label>
    </div>
    <div class="col-sm-12 col-lg-9 form-group">
        <input id="price" name="price" value="{{ $product->price ?? old('price') }}" type="number" aria-describedby="priceHelp" placeholder="$, USD" class="form-control @error('price') is-invalid @enderror">
        <small id="priceHelp" class="form-text text-muted">Only integer</small>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="image1" class="mb-0">Your product image</label>
        @isset($product)
            @if ($product->exists)
                <a href="{{ route('products.images', $product) }}" class="btn btn-outline-secondary mr-2" role="button" aria-pressed="false">Manage images</a>
            @endif
        @else
            <small class="form-text text-muted py-0 my-0">
                You will be able to add product photos in the next step.
            </small>
        @endisset
    </div>
    <div class="col-sm-12 col-lg-9 form-group">
        <div class="row">
        @if (isset($product->images) and $product->images->count() > 0)
            @foreach ($product->images as $image)
                <div class="col-sm-12 col-lg-4">
                    <img src="{{ asset('storage/'.$image->link) }}" class="img-thumbnail" alt="...">
                    <small class="form-text text-muted">
                        <td>{{ date('d-m-Y H:i:s', strtotime($image->created_at)) }}</td>
                    </small>
                </div>
            @endforeach
        @else
            <div class="col-12">
                No product photos
            </div>
        @endisset
        </div>
    </div>
</div>