@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editing {{ $variable->name }}</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form method="POST" action="{{ route('admin.settings.update', $variable) }}" class="w-100">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputName">Name</label>
                                    <input type="text" id="inputName" name="name" class="form-control  @error('name') is-invalid @enderror" value="{{ old('name') ?? $variable->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputUniqName">Uniq name</label>
                                    <input type="text" id="inputUniqName" name="uniq_name" class="form-control  @error('uniq_name') is-invalid @enderror" value="{{ old('uniq_name') ?? $variable->uniq_name }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputValue">Value</label>
                                    <input type="text" id="inputValue" name="value" class="form-control  @error('value') is-invalid @enderror" value="{{ old('value') ?? $variable->value }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Save" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
