@extends('home.layout')

@section('content_p')
    <div class="row">
        <div class="col-12 col-lg-8 mx-auto">
            <div class="d-flex flex-row justify-content-between">
                <h1 class="h4 my-2">{{ __('product.pages.index') }}</h1>
                <a href="{{ route('products.create') }}" type="button" class="btn btn-success py-2"><i class="fa fa-plus" aria-hidden="true"></i> {{ __('product.btn.new') }}</a>
            </div>
            @forelse ($products as $product)
                <hr class="py-1 my-2">
                <div class="row">
                    {{-- col-1 --}}
                    <div class="col-12 col-sm-3">
                        <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                            @if ($product->images->count() > 0)
                                <img src="{{ asset('storage/'.$product->images->first()->link) }}" class="card-img-top" alt="{{ $product->title }}">
                            @else
                                <img src="{{ asset('img/product-no-image.png') }}" class="card-img-top" alt="{{ $product->title }}">
                            @endif
                        </a>
                    </div>
                    {{-- col-2 --}}
                    <div class="col-7 col-sm-7 d-flex flex-column">
                        <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-reset h5 my-1">{!! Str::limit($product->title, 28, '') !!}</a>
                        <div class="w-100">
                            <span class="h5 text-black">{{ $product->price }} $</span>
                            @if($product->price > 0 && $product->hashrate > 0)
                                <span class="text-muted">
                                    <span class="h6">
                                        or {{ round($product->price / $product->hashrate, 2) }}$/th
                                    </span>
                                </span>
                            @endif
                        </div>
                        <div class="w-100">
                            <h6 class="mb-2 text-dark">{{$product->hashrate}}{{App\Product::$hashrates[$product->hashrate_name]}} | {{$product->power}}W | MOQ {{$product->moq}}pcs</h6>
                        </div>
                        <div class="w-100">
                            {!! Str::limit($product->description, 80, '...') !!}
                        </div>
                        <div class="w-100 text-muted">
                            @if(now() < $product->active_at) 
                                {{ __('product.active_at.title') }}: {{ date('d M Y', strtotime($product->active_at)) }}
                            @else
                                {{ __('product.created_at.title') }}: {{ date('d M Y', strtotime($product->created_at)) }}
                            @endif
                        </div>
                    </div>
                    {{-- col-3 --}}
                    <div class="col-5 col-sm-2 d-flex flex-column mt-2 mt-sm-0">
                        @if(is_null($product->active_at))
                            <button type="button" class="btn btn-sm btn-outline-primary mb-1">
                                <i class="fas fa-user-shield"></i> On moderation
                            </button>
                        @else
                            @if(now() < $product->active_at)
                                <button type="button" class="btn btn-sm btn-outline-success my-1">
                                    Active
                                </button>
                            @else
                                <button type="button" class="btn btn-sm btn-secondary my-1">
                                    Expired
                                </button>
                                <form action="{{ route('products.reactivate', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-success btn-sm my-1" type="submit">RePublish</button>
                                </form>
                            @endif
                        @endif
                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-secondary my-1">{{__('product.btn.view')}} <i class="fas fa-eye"></i></a>
                        <a href="{{ route('products.edit', $product) }}" type="button" class="btn btn-sm btn-warning my-1">{{__('product.btn.edit')}} <i class="far fa-edit"></i></a>
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
