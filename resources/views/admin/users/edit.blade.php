@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit user {{ $user->name }}</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="w-100">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">General</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" style="display: block;">
                                <div class="form-group">
                                    <label for="inputName">User Name</label>
                                    <input type="text" id="inputName" name="name" class="form-control  @error('name') is-invalid @enderror" value="{{ $user->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail">User Name</label>
                                    <input type="email" id="inputEmail" name="email" class="form-control  @error('email') is-invalid @enderror" value="{{ $user->email }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputFirstName">First Name</label>
                                    <input type="text" id="inputFirstName" name="first_name" class="form-control  @error('first_name') is-invalid @enderror" value="{{ $user->first_name }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputLastName">Last Name</label>
                                    <input type="text" id="inputLastName" name="last_name" class="form-control  @error('last_name') is-invalid @enderror" value="{{ $user->last_name }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputBio">BIO</label>
                                    <textarea id="inputBio" name="bio" class="form-control @error('bio') is-invalid @enderror" rows="4">{{ $user->bio }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="inputCountry">Country</label>
                                    <select id="inputCountry" name="country" class="form-control custom-select @error('country') is-invalid @enderror">
                                        <option disabled="">Select one</option>
                                        @foreach (App\Country::all() as $country)
                                            <option value="{{ $country->id }}"
                                                @if (old('country') == $country->id || $user->country_id == $country->id) selected @endif>{{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Permission</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="roles">Roles</label>
                                    <div class="col-md-6">
                                        @foreach ($roles as $role)
                                            <div class="form-check">
                                                <input type="checkbox" name="roles[]" class="form-check-input" value="{{ $role->id }}" id="role{{ $role->id }}" @if ($user->roles->pluck('id')->contains($role->id)) checked @endif>
                                                <label for="role{{ $role->id }}" class="form-check-label">{{ $role->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Save Changes" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
