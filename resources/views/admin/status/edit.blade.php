@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editing status {{ $status->name }}</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form method="POST" action="{{ route('admin.statuses.update', $status) }}" class="w-100">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputName">Name</label>
                                    <input type="text" id="inputName" name="name" class="form-control  @error('name') is-invalid @enderror" value="{{ old('name') ?? $status->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputUniqName">Uniq Name</label>
                                    <input type="text" id="inputUniqName" name="uniq_name" class="form-control  @error('uniq_name') is-invalid @enderror" value="{{ old('uniq_name') ?? $status->uniq_name }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <a href="{{ route('admin.statuses.index') }}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Save" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
