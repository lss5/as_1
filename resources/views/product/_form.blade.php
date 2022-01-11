<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="title">Your product title</label>
    </div>
    <div class="col-sm-12 col-lg-9">
        <input name="title" value="{{ old('title') }}" type="text" class="form-control @error('title') is-invalid @enderror" id="title" aria-describedby="titleHelp" placeholder="model or name">
        <small id="titleHelp" class="form-text text-muted">max: 255</small>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-3">
        <label for="description">Your product description</label>
    </div>
    <div class="col-sm-12 col-lg-9">
        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="5">{{ old('description') }}</textarea>
        <small id="descriptionHelp" class="form-text text-muted">Only true information</small>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <button type="submit" class="btn btn-outline-success mr-2" role="button" aria-pressed="true">Create</button>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary mr-2" role="button" aria-pressed="false">Cancel</a>
    </div>
</div>