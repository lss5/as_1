@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit user {{ $user->name}}</div>

                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}

                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" @cannot('restore', $user) readonly @endcannot class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 col-form-label text-md-right">Username</label>

                            <div class="col-md-6">
                                <input id="name" type="name" @cannot('restore', $user) readonly @endcannot class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="roles" class="col-md-2 col-form-label text-md-right">Roles</label>

                            <div class="col-md-6">
                                @foreach ($roles as $role)
                                    <div class="form-check">
                                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" id="role{{ $role->id }}"
                                        @if($user->roles->pluck('id')->contains($role->id)) checked @endif>
                                        <label for="role{{ $role->id }}">{{ $role->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="first_name" class="col-md-2 col-form-label text-md-right">First name</label>

                            <div class="col-md-6">
                                <input id="first_name" name="first_name" type="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $user->first_name) }}" required autofocus>

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="last_name" class="col-md-2 col-form-label text-md-right">Last name</label>

                            <div class="col-md-6">
                                <input id="last_name" name="last_name" type="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $user->last_name) }}" required autofocus>

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="country" class="col-md-2 col-form-label text-md-right">{{ __('Country') }}</label>

                            <div class="col-md-6">
                                <select name="country" id="country" required class="custom-select @error('country') is-invalid @enderror">
                                    <option value selected>Country...</option>
                                    @foreach (App\Country::all() as $country)
                                        <option value="{{ $country->id }}" @if(old('country') == $country->id || $user->country_id == $country->id) selected @endif>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
