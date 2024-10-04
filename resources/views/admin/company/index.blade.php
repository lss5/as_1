@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Companies</h1>
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
                                <div class="card-title">Moderation</div>
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
                                            <th style="width: 10px">User</th>
                                            <th style="width: 10px">Logo</th>
                                            <th>Name</th>
                                            <th>Country</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($companies as $company)
                                            <tr>
                                                <th scope="row">{{ $company->user->name }}</th>
                                                <td>
                                                    @if ($company->images->count() > 0)
                                                        <img class="profile-user-img border-1" src="{{ asset('storage/'.$company->images->first()->link) }}" alt="{{ $company->model }}">
                                                    @else
                                                        @if ($company->product->images->count() > 0)
                                                            <img class="profile-user-img border-1" src="{{ asset('storage/'.$company->product->images->first()->link) }}" alt="{{ $company->model }}">
                                                        @else
                                                            <img class="profile-user-img border-1" src="{{ asset('images/site/no-photo-product.jpeg') }}">
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ $company->name }}</td>
                                                <td>{{ $company->country->name }}</td>
                                                <td>
                                                    {{ $company->status->name }}
                                                </td>
                                                <td class="project-actions">
                                                    <a class="btn btn-info btn-sm" href="{{ route('admin.companies.edit', $company) }}">
                                                        <i class="fas fa-pencil-alt"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.companies.destroy', $company) }}" method="POST" class="form-inline d-inline">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick='return confirm("Delete company?");'>
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
