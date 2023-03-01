@extends('layouts.app')
@section('title'){{ $product->title . ' ('.$product->country->name.') | ' . config('app.name', 'AsicOffer')}}@endsection
@section('description'){!! trim(Str::limit($product->description, 140, '')) !!}@endsection
@section('keywords'){!! Str::title($product->title) !!}@endsection

@section('content')
    <div class="container py-3 my-3">
        <div class="row">
            <div class="col-12">
                <h1 class="h3">
                    @foreach($product->categories as $category)
                        <span class="text-muted">
                            <a href="{{ route('category.show', $category) }}">{{ $category->name }}</a>
                             <i class="fas fa-chevron-right"></i>
                        </span>
                    @endforeach
                    {{ $product->title }}</h1>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="h6 m-0">
                        <i class="fas fa-user"></i>
                        <a href="{{ route('products.user', $product->user) }}">
                            {{ $product->user->name }}
                        </a>
                        <small>({{ $product->country->name }})</small>
                    </p>
                    <small class="text-muted m-0">
                        Registered: {{ date('d M Y', strtotime($product->user->created_at)) }}
                    </small>
                    
                </div>
                @if($product->user->hasVerifiedUser())
                    <h6 class="text-success"><i class="fas fa-user-check text-success"></i> Verified seller</h6>
                @endif

                <div class="d-flex align-items-center justify-content-center" style="min-height: 100px">
                    <h3>
                        {{ $product->price }}$
                        <span class="h6 text-muted">
                            or {{ round($product->price / $product->hashrate, 2) }} $/th
                        </span>
                    </h3>
                    <span class="text-muted">
                    </span>
                </div>
                <div class="d-flex justify-content-around align-items-center">
                    @if (Auth::check())
                        @if($product->user->id != Auth::id())
                            <form action="{{ route('messages.create', $product->user) }}" method="GET" class="form-inline">
                                <input type="hidden" name="parent_id" value="{{ $product->id }}">
                                <button type="submit" class="btn btn-success">
                                    Send message <i class="fas fa-envelope"></i>
                                </button>
                            </form>
                        @endif
                        <a type="submit" href="#" class="btn btn-outline-success">
                            In bookmark <i class="fas fa-bookmark"></i>
                        </a>
                    @else
                        <small class="m-0">Please <a href="{{ route('login') }}">login</a> for send message to seller</small>
                    @endif
                </div>
                <div class="col-sm-12 col-lg-10 my-2">
                    <table class="table table-borderless w-100">
                        <tbody>
                            <tr>
                                <th scope="row">Condition</th>
                                <td>@if($product->isnew) New @else Used @endif</td>
                            </tr>
                            <tr>
                                <th scope="row">Algorithm</th>
                                <td>{{ __('product.algorithms.'.$product->algorithm) }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Hashrate</th>
                                <td>{{ $product->hashrate }} {{ App\Product::$hashrates[$product->hashrate_name] }}</td>
                            </tr>
                            @isset($product->power)
                                <tr>
                                    <th scope="row">Power</th>
                                    <td>{{ $product->power }} W</td>
                                </tr>
                            @endisset
                            <tr>
                                <th scope="row">Quantity</th>
                                <td>{{ $product->quantity }} pcs</td>
                            </tr>
                            <tr>
                                <th scope="row">Minimum order quantity</th>
                                <td>{{ $product->moq }} pcs</td>
                            </tr>
                            <tr>
                                <th scope="row">Published</th>
                                <td>
                                    {{ date('d M Y', strtotime($product->created_at)) }}
                                </td>
                            </tr>
                            @if ($product->algorithm == 'sha256' || $product->algorithm == 'scrypt')
                                <tr>
                                    <th colspan="2" class="text-center">
                                        Profit (24h)
                                    </th>
                                </tr>
                                <tr>
                                    <th scope="row">BTC revenue</th>
                                    <td>
                                        {{ number_format($product->btc_revenue, 8) }}
                                    </td>
                                </tr>
                                @empty($product->power)
                                    <tr>
                                        <th scope="row">
                                            Profit
                                            <small class="form-text text-muted py-0 my-0">
                                                Without power cost
                                            </small>
                                        </th>
                                        <td>
                                            {{ round($product->revenue, 2) }} $
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <th scope="row">USD revenue</th>
                                        <td>
                                            {{ number_format($product->revenue, 2) }} $
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            Cost
                                            <small class="form-text text-muted py-0 my-0">
                                                Calculation at the cost 0,06$/kWt
                                            </small>
                                        </th>
                                        <td>
                                            {{ $product->cost }} $
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Profit</th>
                                        <td>
                                            {{ $product->profit }} $
                                        </td>
                                    </tr>
                                @endempty
                            @endif
                        </tbody>
                    </table>
                </div>
                {{-- <h4>Contacts</h4>
                <table class="table table-sm table-borderless w-auto">
                    <tbody>
                    @foreach ($product->user->contacts as $contact)
                        <tr>
                        @if ($contact->type == 'tg')
                            <th scope="row">
                                <i class="fab fa-telegram fa-lg"></i>
                            </th>
                        @elseif ($contact->type == 'phone')
                            <th scope="row">
                                <i class="fas fa-phone-alt fa-lg"></i>
                            </th>
                        @elseif ($contact->type == 'whatsapp')
                            <th scope="row">
                                <i class="fab fa-whatsapp fa-lg"></i>
                            </th>
                        @endif
                            <td>{{ $contact->value }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table> --}}
                {{ $product->description }}
            </div>
            @if ($product->images->count() > 0)
                <div class="col-md-12 col-lg-6 text-center">
                    @foreach ($product->images as $image)
                    <img src="{{ asset('storage/'.$image->link) }}" class="img img-fluid my-1" alt="{{ $product->title }}">
                    @endforeach
                </div>
            @else
                <div class="col-md-12 col-lg-6">
                    <img src="{{ asset('img/product-no-image.png') }}" class="img img-fluid" alt="{{ $product->title }}">
                </div>
            @endif
        </div>
        {{-- @if (Auth::check() and $product->user->id != Auth::id())
            <div class="row">
                <div class="col-md-12">
                    <hr class="py-1">
                    <form action="{{ route('messages.create') }}" method="GET" class="form-inline">
                        <input type="hidden" name="parent_id" value="{{ $product->id }}">
                        <input type="hidden" name="type" value="plaint">
                        <button type="submit" class="btn btn-sm btn-outline-danger mx-1">
                            Report a scammer <i class="fas fa-headset"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endif --}}

        @can('update', $product)
            <div class="row">
                <div class="col-md-12">
                    <hr class="py-1">
                    <a href="{{ route('products.edit', $product) }}" type="button" class="btn btn-outline-secondary btn-sm mx-1">{{ __('product.btn.edit') }}</a>
                </div>
            </div>
        @endcan
    </div>
@endsection