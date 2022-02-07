<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="title">Your product title</label>
    </div>
    <div class="col-sm-12 col-lg-9 form-group">
        <input name="title" value="{{ old('title') ?? $product->title }}" type="text" class="form-control @error('title') is-invalid @enderror" id="title" aria-describedby="titleHelp">
        <small id="titleHelp" class="form-text text-muted">max: 255 symbols</small>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="category">Category</label>
    </div>
    <div class="col-sm-12 col-lg-9 form-group">
        <select name="category" id="category" class="custom-select @error('category') is-invalid @enderror" aria-describedby="categoryHelp">
            @foreach ($categories as $category)
                @if($product->exists)
                    <option value="{{ $category->id }}" @if(old('category') == $category->id || $product->categories->pluck('id')->first() == $category->id) selected @endif>{{ $category->name }}</option>
                @else
                    <option value="{{ $category->id }}" @if(old('category') == $category->id || $categories['0']->id == $category->id) selected @endif>{{ $category->name }}</option>
                @endif
            @endforeach
        </select>
        @error('category')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="condition">Condition</label>
    </div>
    <div class="col-sm-12 col-lg-9 form-group">
        <div class="custom-control custom-switch">
            <input id="condition" name="condition" type="checkbox" class="custom-control-input"
            @if ($product->exists)
                @if (old('condition') ?? $product->isnew == 1) checked="checked" @endif
            @else
                checked="checked"
            @endif>
            <label class="custom-control-label" for="condition">Brand new</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="description">Your product description</label>
    </div>
    <div class="col-sm-12 col-lg-9 form-group">
        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="5">{{ old('description') ?? $product->description }}</textarea>
        <small id="descriptionHelp" class="form-text text-muted">Max: 4096 symbols</small>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="price">Price, USD</label>
    </div>
    <div class="col-sm-12 col-lg-9 form-group">
        <input id="price" name="price" step="1" value="{{ old('price') ?? $product->price }}" type="number" aria-describedby="priceHelp" class="form-control @error('price') is-invalid @enderror">
        <small id="priceHelp" class="form-text text-muted">Only integer</small>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="quantity">Quantity, pcs</label>
    </div>
    <div class="col-sm-12 col-lg-9 form-group">
        <input id="quantity" name="quantity" step="1" value="{{ old('quantity') ?? $product->quantity }}" type="number" aria-describedby="quantityHelp" class="form-control @error('quantity') is-invalid @enderror">
        <small id="quantityHelp" class="form-text text-muted">Available for sale</small>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="moq">MOQ, pcs</label>
    </div>
    <div class="col-sm-12 col-lg-9 form-group">
        <input id="moq" name="moq" step="1" value="{{ old('moq') ?? $product->moq }}" type="number" aria-describedby="moqHelp" class="form-control @error('moq') is-invalid @enderror">
        <small id="moqHelp" class="form-text text-muted">Minimum order quantity</small>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="power">Power, Watt</label>
    </div>
    <div class="col-sm-12 col-lg-9 form-group">
        <input id="power" name="power" step="1" value="{{ old('power') ?? $product->power }}" type="number" aria-describedby="powerHelp" class="form-control @error('power') is-invalid @enderror">
        <small id="powerHelp" class="form-text text-muted">Device power consumption</small>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="hashrate">Hashrate</label>
    </div>
    <div class="col-sm-12 col-lg-9 form-group">
        <div class="input-group mb-3">
            <input type="text" name="hashrate" id="hashrate" value="{{ old('hashrate') ?? $product->hashrate }}" class="form-control @error('hashrate') is-invalid @enderror" aria-label="Hashrate" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <select class="custom-select @error('hashrateName') is-invalid @enderror" name="hashrateName" id="hashrateName">
                    @foreach (App\Product::$hashrate_names as $uniq => $name)
                        <option @if(old('hashrateName') == $uniq || $product->hashrate_name == $uniq) selected @endif value="{{ $uniq }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            @error('hashrate')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            @error('hashrateName')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="country">Location</label>
    </div>
    <div class="col-sm-12 col-lg-9 form-group">
        <select class="custom-select @error('country') is-invalid @enderror" aria-describedby="countryHelp" name="country" id="country">
            <option value @if($product->country_id) selected @endif>Country...</option>
            @foreach ($countries as $country)
                @if($product->exists)
                    <option value="{{ $country->id }}" @if(old('country') == $country->id || $product->country_id == $country->id) selected @endif>{{ $country->name }}</option>
                @else
                    <option value="{{ $country->id }}" @if(old('country') == $country->id) selected @endif>{{ $country->name }}</option>
                @endif
            @endforeach
        </select>
        <small id="countryHelp" class="form-text text-muted">Where is your product</small>
        @error('country')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="image1" class="mb-0">Photos</label>
        @if ($product->exists)
            <a href="{{ route('products.images', $product) }}" class="btn btn-outline-secondary m-1" role="button" aria-pressed="false">Manage photos <i class="fas fa-camera-retro fa-sm"></i></a>
        @else
            <small class="form-text text-muted py-0 my-0">
                You will be able to add product photos after create listing.
            </small>
        @endif
    </div>
    <div class="col-sm-12 col-lg-9 form-group">
        <div class="row">
        @if ($product->images->count() > 0)
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
<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="active">Active</label>
    </div>
    <div class="col-sm-12 col-lg-9 form-group">
        <div class="custom-control custom-switch">
            <input id="active" name="active" type="checkbox" class="custom-control-input"
            @if ($product->exists)
                @if (old('active') ?? $product->active == 1) checked="checked" @endif
            @else
                checked="checked"
            @endif>
            <label class="custom-control-label" for="active">Show listing in search site</label>
        </div>
    </div>
</div>
