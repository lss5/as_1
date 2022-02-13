@extends('layouts.app')

@section('content')
    <div class="container shadow-sm bg-white rounded my-3 py-3">
        <div class="row">
            @can('update', $product)
                <div class="col-12">
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="form-inline">
                    <a href="{{ route('products.edit', $product) }}" type="button" class="btn btn-primary btn-sm mx-1">Edit</a>
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger mx-1" onclick='return confirm("Удалить ?");'>
                            Delete <i class="fas fa-trash"></i>
                        </button>

                        <table class="table table-sm my-2">
                            <thead>
                                <tr>
                                    <th scope="col">Active</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Date created</th>
                                    <th scope="col">Date updated</th>
                                    <th scope="col">Photos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">@if ($product->active) <i class="fas fa-check-square"></i> @else <i class="fas fa-minus-square"></i> @endif</th>
                                    <td>{{ $product->user->name }}</td>
                                    <td>{{ date('d M Y H:i:s', strtotime($product->created_at)) }}</td>
                                    <td>{{ date('d M Y H:i:s', strtotime($product->updated_at)) }}</td>
                                    <td>{{ $product->images()->count() }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                    <hr class="py-1">
                </div>
            @endcan
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
                            <th scope="row">Location</th>
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
                    <img src="{{ asset('img/product-no-image.jpeg') }}" class="img img-fluid" alt="{{ $product->title }}">
                </div>
            @endif
        </div>
    </div>
@endsection