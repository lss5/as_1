@extends('layouts.app')

@section('content')
    <div class="container py-3 my-3">
        <div class="row">
            <div class="col-12">
                <h1 class="h2">{{ $product->title }}</h1>
            </div>
            <div class="col-md-12 col-lg-6">
                <h4>Seller: {{ $product->user->name }}</h4>
                <table class="table table-sm w-75">
                    <tbody>
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
                                {!! Str::limit($product->country->name, 22, '') !!}
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
                    </tbody>
                </table>
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