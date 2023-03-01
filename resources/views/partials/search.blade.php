<div class="form-group form-row my-0">
    <div class="input-group col-12 col-lg-4 mb-1">
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
    <div class="input-group col-12 col-lg-8 mb-1">
        <input type="text" name="search" class="form-control" id="search" placeholder="search..." value="{{ request()->get('search') ?? '' }}">
        <div class="input-group-append">
            <button type="submit" class="btn btn-success">
                Find <i class="fas fa-search fa-xs"></i>
            </button>
        </div>
    </div>
</div>