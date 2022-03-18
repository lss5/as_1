@extends('layouts.app')

@section('content')
    <div class="container py-3 my-3">
        <div class="row">
            <div class="col-12">
                <h1 class="h3">{{ $product->title }}</h1>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="d-flex justify-content-between align-items-center m-2">
                    <p class="h5 m-0">Seller: <a href="{{ route('products.user', $product->user) }}">{{ $product->user->name }}</a></p>
                    @if (Auth::check())
                        <form action="{{ route('home.messages.create') }}" method="GET" class="form-inline">
                            <input type="hidden" name="parent_id" value="{{ $product->id }}">
                            @if ($product->user->id == Auth::id())
                                <input type="hidden" name="type" value="support">
                                <button type="submit" class="btn btn-sm btn-outline-success mx-1">
                                    Help request <i class="fas fa-headset"></i>
                                </button>
                            @else
                                <input type="hidden" name="type" value="product">
                                <button type="submit" class="btn btn-sm btn-success mx-1">
                                    Send <i class="fas fa-envelope"></i>
                                </button>
                            @endif
                        </form>
                    @else
                        <small class="m-0">Please <a href="{{ route('login') }}">login</a> for send message to seller</small>
                    @endif
                </div>
                @if($product->user->hasVerifiedUser())
                    <h6 class="text-success"><i class="fas fa-user-check text-success"></i> Verified seller</h6>
                @endif
                <div class="col-sm-12 col-lg-10">

                    <table class="table table-sm w-100">
                        <tbody>
                            <tr>
                                <th scope="row">Condition</th>
                                <td>@if($product->isnew) New @else Used @endif</td>
                            </tr>
                            <tr>
                                <th scope="row">Price</th>
                                <td>{{ $product->price }} $</td>
                            </tr>
                            <tr>
                                <th scope="row">Hashrate</th>
                                <td>{{ $product->hashrate }} {{ App\Product::$hashrates[$product->hashrate_name] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Power</th>
                                <td>{{ $product->power }} W</td>
                            </tr>
                            <tr>
                                <th scope="row">Quantity</th>
                                <td>{{ $product->quantity }} pcs</td>
                            </tr>
                            <tr>
                                <th scope="row">Minimum order quantity</th>
                                <td>{{ $product->moq }} pcs</td>
                            </tr>
                            <tr>
                                <th scope="row">Country</th>
                                <td>
                                    <img src="{{ asset('img/flags/'.$product->country->alpha2_code.'.gif') }}" class="img-fluid pb-1" alt="{{$product->country->alpha2_code}}">
                                    {{ $product->country->name }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Category</th>
                                <td>
                                    @foreach($product->categories as $category)
                                        {{ $category->name }}
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Published</th>
                                <td>
                                    {{ date('d M Y', strtotime($product->created_at)) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <h4>Contacts</h4>
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
                </table>
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
        @can('update', $product)
            <div class="row">
                <div class="col-md-12">
                    <hr class="py-1">
                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="form-inline">
                        <a href="{{ route('products.edit', $product) }}" type="button" class="btn btn-primary btn-sm mx-1">Edit</a>
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger mx-1" onclick='return confirm("Delete item?");'>
                            Delete <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endcan
    </div>
@endsection