<div class="col-12">
    <div class="form-row mb-2">
        <div class="input-group col-lg-3 col-sm-6 col-12 mb-2 mb-lg-0">
            <div class="input-group-prepend">
                <span class="input-group-text" id="price">Price, $</span>
            </div>
            <input type="number" name="price_min" class="form-control" id="price_min" value="{{ request()->get('price_min') ?? '' }}" placeholder="min" aria-label="min">
            <input type="number" name="price_max" class="form-control" id="price_max" value="{{ request()->get('price_max') ?? '' }}" placeholder="max" aria-label="max">
        </div>
        <div class="input-group col-lg-2 col-sm-6 col-12 mb-2 mb-lg-0">
            <div class="input-group-prepend">
                <span class="input-group-text" id="moq">MOQ</span>
            </div>
            <input type="number" name="moq" class="form-control" id="moq" value="{{ request()->get('price_min') ?? '' }}" placeholder="pcs" aria-label="pcs">
        </div>
        <div class="input-group col-lg-3 col-sm-6 col-12 mb-2 mb-lg-0">
            <div class="input-group-prepend">
                <span class="input-group-text" id="hashrate">Hashrate</span>
            </div>
            <input type="number" name="hashrate" class="form-control w-25" id="hashrate" value="{{ request()->get('hashrate') ?? '' }}" placeholder="min" aria-label="Hashrate">
            <select class="custom-select" name="hashrateName" id="hashrateName">
                @foreach (App\Product::$hashrates as $uniq => $name)
                    <option @if(request()->get('hashrateName') == $uniq) selected @endif value="{{ $uniq }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-inline form-check mx-2">
            <input id="new" name="new" type="checkbox" value="1" class="custom-control-input"
            @if (request()->get('new') == 1) checked="checked" @endif>
            <label class="custom-control-label" for="new">Brand new</label>
        </div>
        <button type="submit" class="btn btn-primary">Apply</button>

    </div>
</div>