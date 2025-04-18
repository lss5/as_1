@extends('layouts.profile')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @include('partials.alerts')

                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-success card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    @if ($user->images->count() > 0)
                                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/'.$user->images->first()->link) }}" alt="{{ $user->name }}">
                                    @else
                                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('images/common/no-photo-user.png') }}" alt="{{ $user->name }}">
                                    @endif
                                </div>
                                <h3 class="profile-username text-center">{{ $user->first_name . ' ' . $user->last_name }}</h3>
                                <p class="text-muted text-center">{{ $user->name }}</p>
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Listings</b> <a class="float-right" href="{{ route('profile.listings.index') }}">{{ $sum_listings }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Followers</b> <a class="float-right">322</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Following</b> <a class="float-right">54</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">About Me</h3>
                            </div>
                            <div class="card-body">
                                @if ($company)
                                    <strong><i class="fas fa-building mr-1"></i> Company <a href="{{ route('profile.companies.edit', $company) }}" class="text-muted">Edit</a></strong>
                                    <p class="text-muted mb-1">{{ $company->name }} </p>
                                    <p class="text-muted mb-1">{{ $company->legal_address }}</p>
                                    <p class="text-muted">{{ $company->country->name }}</p>
                                    <hr>
                                @endif

                                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                                <p class="text-muted">{{ $user->country->name }}</p>
                                <hr>

                                <strong><i class="fab fa-bitcoin"></i> Payments</strong>
                                <p class="text-muted">{{ $user->payments }}</p>
                                <hr>

                                <strong><i class="far fa-file-alt mr-1"></i> Bio</strong>
                                <p class="text-muted">{{ $user->bio }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <a href="{{ route('profile.listings.active') }}" class="info-box-text text-center text-muted">Active Listings</a>
                                        <span class="info-box-number text-center text-muted mb-0">{{ $active_listings }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        @if ($company)
                                            <span class="info-box-text text-center text-muted">{{ $company->status->name }} Company</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $company->name }}</span>
                                        @else
                                            <span class="info-box-text text-center text-muted">Company (not created)</span>
                                            <a href="{{ route('profile.companies.create') }}" class="btn btn-sm btn-outline-success btn-block">Registration</a>
                                            {{-- <span class="info-box-number text-center text-muted mb-0">{{ $company->name }}</span> --}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Estimated project duration</span>
                                        <span class="info-box-number text-center text-muted mb-0">20</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header p-2">
                                <h3 class="card-title">Information</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('profile.update.image', $user) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="inputPhoto" class="col-sm-2 col-form-label">Photo</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input @error('photo') is-invalid @enderror" name="photo" id="inputPhoto">
                                                    <label class="custom-file-label" for="inputPhoto"></label>
                                                </div>
                                                <div class="input-group-append">
                                                    <button type="submit" class="input-group-text">Update</button>
                                                </div>
                                            </div>
                                            <small id="inputPhotoHelp" class="form-text text-muted">Min. width/height: 500px, Max. size 3Mb</small>
                                        </div>
                                    </div>
                                </form>
                                <form class="form-horizontal" action="{{ route('profile.update', $user) }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="inputEmail" placeholder="{{ $user->email }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="inputName" placeholder="{{ $user->name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputFirstName" class="col-sm-2 col-form-label">First Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="inputFirstName" name="first_name" placeholder="First Name" value="{{ old('first_name') ?? $user->first_name }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputLastName" class="col-sm-2 col-form-label">Last Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="inputLastName" name="last_name" placeholder="First Name" value="{{ old('last_name') ?? $user->last_name }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputBio" class="col-sm-2 col-form-label">BIO</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control @error('bio') is-invalid @enderror" rows="3" id="inputBio" name="bio" placeholder="Experience">{{ old('bio') ?? $user->bio }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPayments" class="col-sm-2 col-form-label">Payments</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control @error('payments') is-invalid @enderror" rows="2" id="inputPayments" name="payments" placeholder="What are the payment methods">{{ old('payments') ?? $user->payments }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputCountry" class="col-sm-2 col-form-label">Country</label>
                                        <div class="col-sm-10">
                                            <select name="country" id="inputCountry" class="custom-select @error('country') is-invalid @enderror">
                                                <option value selected>Select a country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}" @if (old('country') == $country->id || $user->country_id == $country->id) selected @endif>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-danger">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header p-2">
                                <h3 class="card-title">Contacts</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table">
                                            <tbody>
                                                @forelse ($contacts as $contact)
                                                    <tr>
                                                        <td>
                                                            {{ App\Contact::$types[$contact->type] }}
                                                            @if ($contact->ismain)
                                                                <span class="badge badge-success">Main</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $contact->value }}</td>
                                                    </tr>
                                                @empty
                                                    Please add <a href="{{ route('profile.contacts.index') }}">contacts</a>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
