@extends('home.layout')

@section('content_p')
    <div class="row">
        <div class="col-12 col-lg-8 mx-auto">
            <div class="d-flex flex-row justify-content-between">
                @if ($products->count() > 0)
                    <h1 class="h4 my-2">{{ __('product.pages.index') }}</h1>
                @else
                    <h1 class="h4 my-2">{{ __('product.messages.products_empty') }}</h1>
                @endif
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
                        {{-- Status --}}
                        @switch($product->status)
                            @case('active')
                                <button type="button" class="btn btn-sm btn-success mb-1">
                                    <i class="fas fa-check-circle"></i>
                                @break
                            @case('moderation')
                                <button type="button" class="btn btn-sm btn-outline-primary mb-1">
                                    <i class="fas fa-user-shield"></i>
                                @break
                            @case('expired')
                                <button type="button" class="btn btn-sm btn-secondary mb-1">
                                    <i class="fas fa-stopwatch"></i>
                                @break
                            @case('reactivation_rq')
                                <button type="button" class="btn btn-sm btn-primary mb-1">
                                    <i class="fas fa-user-shield"></i>
                                @break
                            @case('banned')
                                <button type="button" class="btn btn-sm btn-danger mb-1">
                                    <i class="fas fa-store-slash"></i>
                                @break
                            @case('canceled')
                                <button type="button" class="btn btn-sm btn-outline-danger mb-1">
                                    <i class="fas fa-shield-alt"></i>
                                @break
                            @case('restored')
                                <button type="button" class="btn btn-sm btn-secondary mb-1">
                                    <i class="fas fa-trash-restore"></i>
                                @break
                            @default
                                <button type="button" class="btn btn-sm btn-outline-secondary mb-1">
                        @endswitch
                            {{ __('product.status.'.$product->status) }}
                        </button>

                        {{-- Actions --}}
                        @switch($product->status)
                            @case('expired')
                                <form action="{{ route('home.products.reactivation', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('POST')
                                    <button class="btn btn-success btn-sm" type="submit">{{ __('product.btn.reactivation_request') }}</button>
                                </form>
                                @break
                            @case('reactivation_rq')
                                @break
                            @case('banned')
                                <form action="{{ route('home.messages.create') }}" method="GET" class="d-inline w-100">
                                    <input type="hidden" name="type" value="support">
                                    <button type="submit" class="btn btn-sm btn-outline-success w-100">
                                        {{ __('product.btn.help') }} <i class="fas fa-headset"></i>
                                    </button>
                                </form>
                                @break
                            @case('canceled')
                                <form action="{{ route('home.messages.create') }}" id="help-request-form" method="GET" class="d-inline">
                                    <input type="hidden" name="type" value="support">
                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                        {{ __('product.btn.help') }} <i class="fas fa-headset"></i>
                                    </button>
                                </form>
                                @break
                            @case('restored')
                                <form action="{{ route('home.products.reactivation', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('POST')
                                    <button class="btn btn-success btn-sm" type="submit">{{ __('product.btn.reactivation_request') }}</button>
                                </form>
                                @break
                            @default
                        @endswitch
                        @can('update', $product)
                            <a href="{{ route('products.edit', $product) }}" type="button" class="btn btn-sm btn-warning my-1">{{__('product.btn.edit')}} <i class="far fa-edit"></i></a>
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
