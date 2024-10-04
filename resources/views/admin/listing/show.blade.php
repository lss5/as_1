@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $listing->user->name }} : {{ $listing->product->manufacturer->name . ' ' . $listing->product->model }}</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form method="POST" action="{{ route('admin.listings.update', $listing) }}" class="w-100">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    @if ($listing->images->count() > 0)
                                        <img class="profile-user-img border-1" src="{{ asset('storage/'.$listing->images->first()->link) }}">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" @if (old('condition') ?? $listing->is_new == 1) checked="checked" @endif name="condition" id="checkboxCondition" disabled>
                                        <label class="custom-control-label" for="checkboxCondition">New product (not used)</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputQuantity">Product</label>
                                    <input type="text" value="{{ $listing->product->manufacturer->name . ' ' . $listing->product->model }}" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="inputQuantity">Quantity</label>
                                    <input type="number" step="1" min="1" id="inputQuantity" name="quantity" value="{{ $listing->quantity }}" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="inputMoq">Minimum order quantity</label>
                                    <input type="number" step="1" min="1" id="inputMoq" name="moq" value="{{ $listing->moq }}" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="inputPrice">Price</label>
                                    <input type="number" step="1" min="1" id="inputPrice" name="price" value="{{ $listing->price }}" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="inputSerialNumber">Serial Number</label>
                                    <input type="text" id="inputSerialNumber" name="serial_number" value="{{ $listing->serial_number }}" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="inputCountry">Location of product</label>
                                    <input type="text" id="inputCountry" name="country" value="{{ $listing->country->name }}" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" rows="4" name="description" placeholder="Enter ..." disabled>{{ $listing->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="selectStatus">Status</label>
                                    <select class="custom-select rounded-0 @error('status_id') is-invalid @enderror" name="status" id="selectStatus">
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}" @if($listing->status->id == $status->id) selected @endif>{{ $status->name }}</option>
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
