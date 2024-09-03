@extends('layouts.profile')

@section('content')
    <div class="row">
        <div class="col-12 col-lg-8 mx-auto">
            <div class="d-flex flex-row justify-content-between">
                @if ($products->count() > 0)
                    <h1 class="h4 my-2">{{ __('product.pages.index') }}</h1>
                @else
                    <h1 class="h4 my-2">{{ __('product.messages.products_empty') }}</h1>
                @endif
                <a href="{{ route('profile.listing.create') }}" type="button" class="btn btn-sm btn-success my-2"><i class="fa fa-plus" aria-hidden="true"></i> {{ __('product.btn.new') }}</a>
            </div>
            @forelse ($products as $product)
                <hr class="py-1 my-1">
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
                        <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-reset h5 my-1">
                            {!! Str::limit($product->title, 28, '') !!}
                            {{-- Status --}}
                            @switch($product->status)
                                @case('created')
                                    <span class="badge badge-primary">
                                        <i class="fas fa-check"></i>
                                    @break
                                @case('active')
                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i>
                                    @break
                                @case('moderation')
                                    <span class="badge badge-primary">
                                        <i class="fas fa-user-shield"></i>
                                    @break
                                @case('moderated')
                                    <span class="badge badge-success">
                                        <i class="fas fa-user-check"></i>
                                    @break
                                @case('expired')
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-stopwatch"></i>
                                    @break
                                @case('banned')
                                    <span class="badge badge-danger">
                                        <i class="fas fa-store-slash"></i>
                                    @break
                                @case('canceled')
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-undo-alt"></i>
                                    @break
                                @case('restored')
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-trash-restore"></i>
                                    @break
                                @default
                                    <span class="badge badge-secondary">
                            @endswitch
                                {{ __('product.status.'.$product->status) }}
                                </span>
                        </a>
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
                        {{-- Actions --}}
                            {{-- Verify --}}
                        @if (in_array($product->status,['created','expired','restored']))
                            <form action="{{ route('profile.listing.verify', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method('POST')
                                <button class="btn btn-success btn-sm w-100" type="submit">
                                    <i class="fas fa-user-shield"></i></i> {{ __('product.btn.verify') }}
                                </button>
                            </form>
                        @endif
                            {{-- Activate --}}
                        @if (in_array($product->status, ['moderated','canceled']))
                        <form action="{{ route('profile.listing.activate', $product) }}" method="POST" class="d-inline">
                            @csrf
                            @method('POST')
                            <button class="btn btn-success btn-sm w-100" type="submit">
                                <i class="fas fa-globe"></i></i> {{ __('product.btn.publish') }}
                            </button>
                        </form>
                        @endif
                            {{-- Help --}}
                        @if (in_array($product->status, ['banned','canceled']))
                            <form action="{{ route('profile.support.create') }}" method="GET" class="d-inline">
                                <input type="hidden" name="type" value="support">
                                <button type="submit" class="btn btn-sm btn-outline-primary w-100 my-1">
                                    {{ __('product.btn.help') }} <i class="fas fa-headset"></i>
                                </button>
                            </form>
                        @endif
                            {{-- Unpublish --}}
                        @if (in_array($product->status, ['active']))
                        <form action="{{ route('profile.listing.unpublish', $product) }}" method="POST" class="d-inline">
                            @csrf
                            @method('POST')
                            <button class="btn btn-secondary btn-sm w-100" type="submit">
                                <i class="fas fa-undo-alt"></i> {{ __('product.btn.unpublish') }}
                            </button>
                        </form>
                        @endif

                        @can('update', $product)
                            <a href="{{ route('profile.listing.edit', $product) }}" type="button" class="btn btn-sm btn-warning my-1 w-auto">{{__('product.btn.edit')}} <i class="far fa-edit"></i></a>
                        @endcan
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-center my-1">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
@endsection
