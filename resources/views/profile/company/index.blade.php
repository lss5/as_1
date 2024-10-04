@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Listings</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                @include('partials.alerts')

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">{{ $card_title }}</div>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-right">
                                        <li class="page-item"><a class="page-link" href="#">«</a></li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">»</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-bordered table-striped dtr-inline">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">Photo</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>MOQ</th>
                                            <th>Serial number</th>
                                            <th>Price</th>
                                            <th>Location</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listings as $listing)
                                            <tr>
                                                <th scope="row">
                                                    @if ($listing->images->count() > 0)
                                                        <img class="profile-user-img border-1" src="{{ asset('storage/'.$listing->images->first()->link) }}" alt="{{ $listing->model }}">
                                                    @else
                                                        @if ($listing->product->images->count() > 0)
                                                            <img class="profile-user-img border-1" src="{{ asset('storage/'.$listing->product->images->first()->link) }}" alt="{{ $listing->model }}">
                                                        @else
                                                            <img class="profile-user-img border-1" src="{{ asset('images/site/no-photo-product.jpeg') }}">
                                                        @endif
                                                    @endif
                                                </th>
                                                <td>{{ $listing->product->manufacturer->name . ' ' . $listing->product->model }} @if ($listing->is_new) (NEW) @endif</td>
                                                <td>{{ $listing->quantity }}</td>
                                                <td>{{ $listing->moq }}</td>
                                                <td>{{ $listing->serial_number }}</td>
                                                <td>{{ $listing->price }}</td>
                                                <td>{{ $listing->country->name }}</td>
                                                <td>{{ $listing->status->name . ' ' . $listing->status_changed_at }} </td>
                                                <td class="project-actions">
                                                    <a class="btn btn-info btn-sm" href="{{ route('profile.listings.edit', $listing) }}">
                                                        <i class="fas fa-pencil-alt"></i> Edit
                                                    </a>
                                                    <form action="{{ route('profile.listings.destroy', $listing) }}" method="POST" class="form-inline d-inline">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick='return confirm("Delete product model?");'>
                                                            <i class="fas fa-trash"></i> Detete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
