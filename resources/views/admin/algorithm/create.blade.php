@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Creating new algorithm</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form method="POST" action="{{ route('admin.algorithms.store') }}" class="w-100">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputName">Name</label>
                                    <input type="text" id="inputName" name="name" class="form-control  @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputUniqName">Uniq name</label>
                                    <input type="text" id="inputUniqName" name="uniq_name" class="form-control  @error('uniq_name') is-invalid @enderror" value="{{ old('uniq_name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputHashrateName">Hashrate name</label>
                                    <input type="text" id="inputHashrateName" name="hashrate_name" class="form-control  @error('hashrate_name') is-invalid @enderror" value="{{ old('hashrate_name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputSort">Sort order</label>
                                    <input type="number" step="1" id="inputSort" name="sort" class="form-control  @error('sort') is-invalid @enderror" value="{{ old('sort') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <input type="submit" value="Create" class="btn btn-success">
                        <a href="{{ route('admin.algorithms.index') }}" class="btn btn-secondary float-right">Cancel</a>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
