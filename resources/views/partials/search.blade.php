<div class="col-12 ">
    <div class="form-row">
        <div class="form-group col-md-6 col-sm-12">
            <label for="search">Name</label>
            <input type="text" name="search" class="form-control" id="search" placeholder="Model or Manufacturer" value="{{ request()->get('search') ?? '' }}">
        </div>
        <div class="form-group col-md-3 col-sm-12">
            <label for="country">Country</label>
            <select name="country" id="country" class="form-control" aria-describedby="countryHelp">
                <option value @empty(request()->get('country')) selected @endempty>Choise...</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" @if(request()->get('country') == $country->id) selected @endif>{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3 col-sm-12">
            <label for="category">Category</label>
            <select name="category" id="category" class="form-control" aria-describedby="categoryHelp">
                <option value @empty(request()->get('category')) selected @endempty>Choise...</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @if(request()->get('category') == $category->id) selected @endif>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-2 col-sm-6 col-xs-12">
            <label for="price">Price max, $</label>
            <input type="number" name="price" class="form-control" id="price" value="{{ request()->get('price') ?? '' }}">
        </div>
        <div class="form-group col-md-2 col-sm-6 col-xs-12">
            <label for="moq">MOQ, pcs</label>
            <input type="number" name="moq" class="form-control" id="moq" value="{{ request()->get('moq') ?? '' }}">
        </div>
        <div class="form-group col-md-2 col-sm-6 col-xs-12">
            <label for="power">Power max, w</label>
            <input type="number" name="power" class="form-control" id="power" value="{{ request()->get('power') ?? '' }}">
        </div>
        <div class="form-group col-md-2 col-sm-6 col-xs-12">
            <label for="hashrate">Hashrate, min</label>
            <div class="input-group">
                <input type="number" name="hashrate" class="form-control" id="hashrate" value="{{ request()->get('hashrate') ?? '' }}" aria-label="Hashrate" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <select class="custom-select" name="hashrateName" id="hashrateName">
                        @foreach (App\Product::$hashrates as $uniq => $name)
                            <option @if(request()->get('hashrateName') == $uniq) selected @endif value="{{ $uniq }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group col-md-2 col-sm-6">
            <label for="user">Seller</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">@</div>
                </div>
                <input type="text" value="{{ request()->get('user') ?? '' }}" class="form-control" name="user" placeholder="Username">
            </div>
        </div>
        <div class="form-group col-md-2 col-sm-6 form-group">
            <label for="user">Brand new</label>

            <div class="custom-control custom-switch">
                <input id="new" name="new" type="checkbox" value="1" class="custom-control-input"
                    @if (request()->get('new') == 1) checked="checked" @endif>
                <label class="custom-control-label" for="new">Only</label>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-sm btn-primary">Search</button>
    {{-- <button type="button" class="btn btn-sm btn-secondary" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="collapseFilter collapseFilterButton">
        <i class="far fa-eye-slash"></i>
    </button> --}}
</div>