@extends('home.layout')

@section('content_p')
    <div class="row">
        <div class="col-12 col-lg-8 mx-auto">
            <div class="d-flex flex-row justify-content-between">
                <h1 class="h4 my-2">{{ __('product.pages.index') }}</h1>
                <a href="{{ route('products.create') }}" type="button" class="btn btn-success py-2"><i class="fa fa-plus" aria-hidden="true"></i> {{ __('product.btn.new') }}</a>
            </div>
            @forelse ($products as $product)
                <hr class="py-1">
                <div class="row">
                    {{-- col-1 --}}
                    <div class="col-3">
                        <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                            @if ($product->images->count() > 0)
                                <img src="{{ asset('storage/'.$product->images->first()->link) }}" class="card-img-top" alt="{{ $product->title }}">
                            @else
                                <img src="{{ asset('img/product-no-image.png') }}" class="card-img-top" alt="{{ $product->title }}">
                            @endif
                        </a>
                    </div>
                    {{-- col-2 --}}
                    <div class="col-7 d-flex flex-column">
                        <div class="w-100">
                            @if(is_null($product->active_at))
                            <button type="button" class="btn btn-sm btn-outline-secondary" disabled>
                                On moderation
                            </button>
                        @else
                            @if(now() < $product->active_at)
                                <button type="button" class="btn btn-sm btn-success active">
                                    Active
                                    (expires {{ date('d M', strtotime($product->active_at)) }})
                                </button>
                            @else
                                <button type="button" class="btn btn-sm btn-secondary">
                                    Expired
                                    {{ date('d M', strtotime($product->active_at)) }}
                                </button>
                                <form action="{{ route('products.reactivate', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-success btn-sm" type="submit">RePublish</button>
                                </form>
                            @endif
                        @endif
                        </div>
                        <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-reset h5 my-1">{!! Str::limit($product->title, 28, '') !!}</a>
                        <div class="w-100">
                            <span class="h5 text-success">{{ $product->price }}$</span>
                            <span class="badge badge-success">
                                <span class="h6">
                                    {{ round($product->revenue, 2) }} $/day
                                </span>
                            </span>
                        </div>
                        <div class="w-100">
                            <h6 class="mb-2 text-muted">{{$product->hashrate}}{{App\Product::$hashrates[$product->hashrate_name]}} | {{$product->power}}W | MOQ {{$product->moq}}pcs</h6>
                        </div>
                        <div class="w-100">
                            {!! Str::limit($product->description, 80, '...') !!}
                        </div>
                    </div>
                    {{-- col-3 --}}
                    <div class="col-2 d-flex flex-column">
                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-secondary mb-1">View</a>
                        <a href="{{ route('products.edit', $product) }}" type="button" class="btn btn-outline-dark btn-sm mb-1">Edit</a>
                        {{-- <form action="{{ route('products.destroy', $product) }}" method="POST" class="form-inline">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100" onclick='return confirm("Delete item?");'>
                                Delete <i class="fas fa-trash"></i>
                            </button>
                        </form> --}}
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <h2 class="h4">No products selling</h2>
                </div>
            @endforelse
        </div>
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-center my-1">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
@endsection
