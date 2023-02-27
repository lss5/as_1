@extends('layouts.app')

@section('content')
<div class="container">
    <form method="GET" action="{{ route('products.index') }}" class="w-100">
        @include('partials.search')
        <div class="row collapse multi-collapse @if($searchForm) show @endif" id="collapseFilter">
            @include('partials.filters')
        </div>
        <div class="row" id="collapseFilterButton">
            <div class="col-12">
                <div class="form-inline">
                    <button type="button" class="btn btn-sm btn-secondary" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="collapseFilter collapseFilterButton">
                        Filters <i class="fas fa-filter"></i>
                    </button>
                    <div class="input-group mx-2 w-auto">
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
        </div>
    </form>

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
