@extends('layouts.app')

@section('content')
<form method="GET" action="{{ route('products.index') }}" class="container">
    <div class="d-flex flex-row flex-wrap justify-content-between mt-2 mb-1">

        <div class="d-flex flex-row justify-content-center flex-wrap">
            @foreach (App\Category::where('top_menu', true)->orderBy('sort', 'asc')->get() as $category)
            <a href="{{ route('category.show', $category) }}" class="btn btn-sm {{ (request()->is('category/'.$category->id )) ? 'btn-outline-success' : 'btn-success' }} mr-1">{{ $category->name }}</a>
        @endforeach
        </div>

        <div class="form-inline" id="collapseFilterButton">
            <button type="button" class="btn btn-sm btn-secondary" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="collapseFilter collapseFilterButton">
                Filters <i class="fas fa-filter"></i>
            </button>
            <div class="input-group ml-1 w-auto">
                <select class="custom-select custom-select-sm" id="order" name="order" aria-label="Sort">
                    @foreach (App\Product::$sorting as $key => $value)
                        <option value="{{ $key }}" @if($key == request()->get('order')) selected @endif>{{ $value }}</option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <button class="btn btn-sm btn-outline-secondary" type="submit">Sort <i class="fas fa-sort-amount-down-alt"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="row collapse multi-collapse @if($searchForm) show @endif" id="collapseFilter">
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
                <div class="input-group col-lg-3 col-sm-6 col-12 mb-2 mb-lg-0 mb-md-0">
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
                <button type="submit" class="btn btn-success">Apply</button>
            </div>
        </div>
    </div>
</form>

<div class="container">
    <div class="row my-2">
        @if($products->count() < 1)
            <div class="col-12">
                <h5>No find results</h5>
            </div>
        @else
            @forelse ($products as $product)
            <div class="col-sm-12 col-md-6 col-lg-4 my-1">
                @include('partials.product_card')
            </div>
            @endforeach
            <div class="col-12 d-flex justify-content-center my-1">
                {{ $products->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
