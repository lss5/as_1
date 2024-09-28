@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Product models</h1>
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
                                <div class="card-title">
                                    <a href="{{ route('admin.products.create') }}" type="button" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-plus"></i> Create
                                    </a>
                                </div>
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
                                            <th>Manufacturer</th>
                                            <th>Model</th>
                                            <th>Hashrate</th>
                                            <th>Power</th>
                                            <th>Coins</th>
                                            <th>Algorithms</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <th scope="row">
                                                    @if ($product->images->count() > 0)
                                                        <img class="profile-user-img border-1" src="{{ asset('storage/'.$product->images->first()->link) }}" alt="{{ $product->model }}">
                                                    @else
                                                        <img class="profile-user-img border-1" src="{{ asset('images/site/no-photo-product.jpeg') }}">
                                                    @endif
                                                </th>
                                                <td>{{ $product->manufacturer->name }}</td>
                                                <td>{{ $product->model }}</td>
                                                <td>{{ $product->hashrate }}</td>
                                                <td>{{ $product->power }}</td>
                                                <td>
                                                    @foreach ($product->coins as $coin)
                                                        {{ $coin->name }}
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($product->algorithms as $algorithm)
                                                        {{ $algorithm->name }}
                                                    @endforeach
                                                </td>
                                                <td class="project-actions">
                                                    <a class="btn btn-info btn-sm" href="{{ route('admin.products.edit', $product) }}">
                                                        <i class="fas fa-pencil-alt"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="form-inline d-inline">
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
