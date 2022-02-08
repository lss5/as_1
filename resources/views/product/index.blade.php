@extends('layouts.app')

@section('content')
<div class="container my-2">
    <div class="row collapse multi-collapse show" id="collapseFilterButton">
        <div class="col-12">
            <button type="button" class="btn btn-sm btn-secondary" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="collapseFilter collapseFilterButton">
                Filters <i class="fas fa-search fa-xs"></i>
            </button>
        </div>
    </div>
    <div class="row collapse multi-collapse" id="collapseFilter">
        @include('partials.search')
    </div>

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
