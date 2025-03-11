@extends('layouts.app')

@section('content')
<form method="GET" action="{{ route('listings.index') }}" class="container">
    <div class="d-flex flex-row flex-wrap justify-content-between mt-2 mb-1">

        <div class="d-flex flex-row justify-content-center flex-wrap">
            @foreach (App\Category::where('top_menu', true)->orderBy('sort', 'asc')->get() as $category)
                <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-success mr-1 mb-1">{{ $category->name }}</a>
            @endforeach
        </div>

        <div class="form-inline" id="collapseFilterButton">
            <button type="button" class="btn btn-sm btn-secondary" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="collapseFilter collapseFilterButton">
                Filters <i class="fas fa-filter"></i>
            </button>
            <div class="input-group ml-1 w-auto">
                <select class="custom-select custom-select-sm" id="order" name="order" aria-label="Sort">
                    @foreach (App\Listing::$sorting as $key => $value)
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
        @include('partials.filters')
    </div>
    @include('partials.search')
</form>

<div class="container">
    <div class="row my-2">
        @if($listings->count() < 1)
            <div class="col-12">
                <h5>No find results</h5>
            </div>
        @else
            @forelse ($listings as $product)
            <div class="col-sm-12 col-md-6 col-lg-4 my-1">
                @include('partials.product_card')
            </div>
            @endforeach
            <div class="col-12 d-flex justify-content-center my-1">
                {{ $listings->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
