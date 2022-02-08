@extends('layouts.app')

@section('content')
<div class="container shadow-sm bg-white rounded py-3">
    <form method="GET" action="{{ route('admin.products.index') }}" class="w-100">
        <div class="row my-2" id="collapseFilterButton">
            <div class="col-12">
                <div class="form-inline">
                    <button type="button" class="btn btn-sm btn-secondary" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="collapseFilter collapseFilterButton">
                        Filters <i class="fas fa-search fa-xs"></i>
                    </button>
                    <div class="input-group mx-2">
                        <select class="custom-select custom-select-sm" id="order" name="order" aria-label="Sort">
                            @foreach (App\Product::$sorting as $key => $value)
                                <option value="{{ $key }}" @if($key == request()->get('order')) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-outline-secondary" type="submit">Sort</button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="row collapse multi-collapse @if($searchForm) show @endif" id="collapseFilter">
            @include('partials.search')
        </div>
    </form>

    <div class="row my-2">
        <div class="col-12">
            <h3>Manage listings</h3>
        </div>
        @empty($products)
            <div class="col-12">
                <h4>No product created</h4>
            </div>
        @endempty
        @isset($products)
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Title</th>
                            <th scope="col">Creator</th>
                            <th scope="col">Location</th>
                            <th scope="col">Price</th>
                            <th scope="col">Hashrate</th>
                            <th scope="col">Power</th>
                            <th scope="col">MOQ</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Create</th>
                            <th scope="col">Update</th>
                            <th scope="col">Active</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <th scope="row">{{ $product->id }}</th>
                            <td><a href="{{ route('admin.products.show', $product) }}">{!! Str::limit($product->title, 25, '') !!}</a></td>
                            <td>{{ $product->user->name }}</td>
                            <td>{!! Str::limit($product->country->name, 22, '') !!}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->hashrate }} {{ $product->hashrate_name }}</td>
                            <td>{{ $product->power }}</td>
                            <td>{{ $product->moq }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ date('d-m-Y H:i:s', strtotime($product->created_at)) }}</td>
                            <td>{{ date('d-m-Y H:i:s', strtotime($product->updated_at)) }}</td>
                            <td class="text-center">@if ($product->active) <i class="fas fa-check fa-2x"></i> @else <i class="fas fa-times fa-2x"></i> @endif</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-12 d-flex justify-content-center my-1">
                {{ $products->withQueryString()->links() }}
            </div>
        @endisset
    </div>
</div>
@endsection
