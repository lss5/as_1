@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Statuses</h1>
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
                                    <a href="{{ route('admin.statuses.create') }}" type="button" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-plus"></i> Create
                                    </a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#ID</th>
                                            <th>Name</th>
                                            <th>Uniq name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($statuses as $status)
                                            <tr>
                                                <th scope="row">{{ $status->id }}</th>
                                                <td>{{ $status->name }}</td>
                                                <td>{{ $status->uniq_name }}</td>
                                                <td class="project-actions">
                                                    <a class="btn btn-info btn-sm" href="{{ route('admin.statuses.edit', $status) }}">
                                                        <i class="fas fa-pencil-alt"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.statuses.destroy', $status) }}" method="POST" class="form-inline d-inline">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick='return confirm("Delete status?");'>
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
