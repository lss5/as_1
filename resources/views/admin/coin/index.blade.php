@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Coins</h1>
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
                                    <a href="{{ route('admin.coins.create') }}" type="button" class="btn btn-outline-success btn-sm">
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
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#ID</th>
                                            <th>Name</th>
                                            <th>Short name</th>
                                            <th>Sort</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($coins as $coin)
                                            <tr>
                                                <th scope="row">{{ $coin->id }}</th>
                                                <td>{{ $coin->name }}</td>
                                                <td>{{ $coin->short_name }}</td>
                                                <td>{{ $coin->sort }}</td>
                                                <td class="project-actions">
                                                    <a class="btn btn-info btn-sm" href="{{ route('admin.coins.edit', $coin) }}">
                                                        <i class="fas fa-pencil-alt"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.coins.destroy', $coin) }}" method="POST" class="form-inline d-inline">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick='return confirm("Delete coin?");'>
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
