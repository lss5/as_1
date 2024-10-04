@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Moderate {{ $company->name }}</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form method="POST" action="{{ route('admin.companies.update', $company) }}" class="w-100">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                @foreach ($company->images as $image)
                                    <div class="form-group">
                                        <img class="profile-user-img border-1" src="{{ asset('storage/'.$image->link) }}">
                                    </div>
                                @endforeach
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" value="{{ $company->name}}" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" rows="4" name="description" placeholder="Enter ..." disabled>{{ $company->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Legal Address</label>
                                    <input type="text" name="legal_address" value="{{ $company->legal_address }}" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Actual Address</label>
                                    <input type="text" name="actual_address" value="{{ $company->actual_address }}" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Location of company</label>
                                    <input type="text" name="country" value="{{ $company->country->name }}" class="form-control" disabled>
                                </div>
                                
                                <div class="form-group">
                                    <label for="selectStatus">Status</label>
                                    <select class="custom-select rounded-0 @error('status_id') is-invalid @enderror" name="status" id="selectStatus">
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}" @if($company->status->id == $status->id) selected @endif>{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <a href="{{ route('admin.listings.index') }}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Save" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
