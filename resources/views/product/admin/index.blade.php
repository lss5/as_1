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
                    <div class="input-group mx-2 w-auto">
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

    @include('partials.alerts')

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
                            <th scope="col">Create</th>
                            <th scope="col">Status changed</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr @if(!is_null($product->deleted_at))class="table-secondary"@endif>
                            <th scope="row">{{ $product->id }}</th>
                            <td class="d-flex flex-column">
                                <a href="{{ route('products.show', $product) }}">{!! Str::limit($product->title, 25, '') !!}</a>
                                @switch($product->status)
                                    @case('active')
                                        <button type="button" class="btn btn-sm btn-outline-success">
                                        @break
                                    @case('moderation')
                                        <button type="button" class="btn btn-sm btn-outline-primary">
                                        @break
                                    {{-- @case('expired')
                                        <button type="button" class="btn btn-sm btn-outline-secondary">
                                        @break
                                    @case('reactivation_rq')
                                        <button type="button" class="btn btn-sm btn-secondary">
                                        @break --}}
                                    @case('banned')
                                        <button type="button" class="btn btn-sm btn-danger">
                                        @break
                                    @case('canceled')
                                        <button type="button" class="btn btn-sm btn-secondary">
                                        @break
                                    @case('restored')
                                        <button type="button" class="btn btn-sm btn-secondary">
                                        @break
                                    @default
                                        <button type="button" class="btn btn-sm btn-outline-secondary">
                                @endswitch
                                    {{ __('product.status.'.$product->status) }}
                                </button>
                            </td>
                            <td>{{ $product->user->name }}</td>
                            <td>{!! Str::limit($product->country->name, 22, '') !!}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->hashrate }} {{ $product->hashrate_name }}</td>
                            <td>{{ date('d-m-Y', strtotime($product->created_at)) }}</td>
                            <td>{{ date('d-m h:i', strtotime($product->status_changed_at)) }}</td>
                            <td>
                                @if($product->trashed())
                                    <form action="{{ route('admin.products.restore', $product) }}" method="POST" class="mx-auto">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-outline-primary btn-sm" type="submit">Restore</button>
                                    </form>
                                @else

                                @error('status')
                                    <small class="form-text text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                                <form action="{{ route('admin.products.set_status', $product) }}" method="POST">
                                    <select name="status" id="status" class="custom-select @error('status') is-invalid @enderror" aria-describedby="statusHelp">
                                        @foreach (App\Product::$statuses as $status)
                                            <option value="{{ $status }}" @if($status == $product->status || $status == old('status')) selected @endif>{{ ucfirst($status) }}</option>
                                        @endforeach
                                        @csrf
                                        @method('POST')
                                        <button class="btn btn-warning btn-sm" type="submit">{{ __('product.btn.change') }}</button>
                                    </select>
                                </form>
{{-- 
                                @switch($product->status)
                                    @case('active')
                                        <small class="d-block text-muted">Expired {{ date('d M', strtotime($product->active_at)) }}</small>
                                        <form action="{{ route('admin.products.set_status', ['product' => $product, 'status' => 'banned']) }}" method="POST">
                                            <input type="hidden" name="status" value="ban">
                                            @csrf
                                            @method('POST')
                                            <button class="btn btn-outline-danger btn-sm" type="submit">Ban</button>
                                        </form>
                                        @break
                                    @case('moderation')
                                        <form action="{{ route('admin.products.set_status', ['product' => $product, 'status' => 'active']) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <button class="btn btn-success btn-sm" type="submit">Activate</button>
                                        </form>
                                        <form action="{{ route('admin.products.set_status', ['product' => $product, 'status' => 'banned']) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <button class="btn btn-outline-danger btn-sm mt-1" type="submit">Ban</button>
                                        </form>
                                        <form action="{{ route('admin.products.set_status', ['product' => $product, 'status' => 'banned']) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <button class="btn btn-outline-danger btn-sm mt-1" type="submit">Ban</button>
                                        </form>
                                        @break
                                    @case('expired')
                                        <form action="{{ route('admin.products.set_status', ['product' => $product, 'status' => 'active']) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <button class="btn btn-success btn-sm" type="submit">ReActivate</button>
                                        </form>
                                        @break
                                    @case('banned')
                                        
                                        @break
                                    @case('canceled')
                                        <button type="button" class="btn btn-sm btn-secondary my-1">
                                            Canceled
                                        </button>
                                        @break
                                    @case('restored')
                                        <button type="button" class="btn btn-sm btn-secondary my-1">
                                            Restored
                                        </button>
                                        <form action="{{ route('admin.products.set_status', ['product' => $product, 'status' => 'banned']) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <button class="btn btn-outline-danger btn-sm mt-1" type="submit">Ban</button>
                                        </form>
                                        @break
                                    @default
                                        
                                @endswitch --}}
                                    @if(is_null($product->active_at))
                                        {{-- <form action="{{ route('admin.products.activate', $product) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-success btn-sm" type="submit">Activate</button>
                                        </form> --}}
                                    @else
                                        @if(now() < $product->active_at)
                                            {{-- <button type="button" class="btn btn-sm btn-outline-success">
                                                Act {{ date('d M', strtotime($product->active_at)) }}
                                            </button> --}}
                                        @else
                                            {{-- <form action="{{ route('products.reactivate', $product) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">RePublic ({{ date('d M', strtotime($product->active_at)) }})</button>
                                            </form> --}}
                                        @endif
                                    @endif
                                @endif
                            </td>
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
