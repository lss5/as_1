@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Creating new contact</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form method="POST" action="{{ route('profile.contacts.store') }}" class="w-100">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="selectType">Type</label>
                                    <select class="custom-select rounded-0 @error('type') is-invalid @enderror" name="type" id="selectType">
                                        @foreach ($types as $uniq => $name)
                                            <option @if(old('type') == $uniq) selected @endif value="{{ $uniq }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputValue">Number/Username</label>
                                    <input type="text" id="inputValue" name="value" class="form-control  @error('value') is-invalid @enderror" value="{{ old('value') }}">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" checked name="main" id="checkboxMain">
                                        <label class="custom-control-label" for="checkboxMain">Main contact</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <a href="{{ route('profile.contacts.index') }}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Create" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
