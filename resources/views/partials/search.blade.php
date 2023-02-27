<div class="form-group form-row my-0">
    <div class="input-group col-md-6 col-sm-12 my-2">
        <div class="input-group-prepend">
            <label class="input-group-text" for="category">Category</label>
        </div>
        <select name="category" id="category" class="custom-select">
            {{-- <option value @empty(request()->get('country')) selected @endempty>country...</option> --}}
            @foreach (App\Category::where('top_menu', false)->orderBy('sort', 'asc')->get() as $category)
                <option value="{{ $category->id }}" @if(request()->get('category') == $category->id) selected @endif>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="input-group col-md-6 col-sm-12 mb-2 mt-md-2">
        <div class="input-group-prepend">
            <label class="input-group-text" for="country">Country</label>
        </div>
        <select name="country" id="country" class="custom-select">
            <option value @empty(request()->get('country')) selected @endempty>choise...</option>
            @foreach ($countries as $country)
                <option value="{{ $country->id }}" @if(request()->get('country') == $country->id) selected @endif>{{ $country->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="input-group col-sm-12 mb-2">
        <input type="text" name="search" class="form-control" id="search" placeholder="search..." value="{{ request()->get('search') ?? '' }}">
        <div class="input-group-append">
            <button type="submit" class="btn btn-primary">
                Find <i class="fas fa-search fa-xs"></i>
            </button>
        </div>
    </div>
</div>