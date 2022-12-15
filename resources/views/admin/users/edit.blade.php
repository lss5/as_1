@extends('admin.layout')

@section('content_p')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-8 my-2">
            <h3>Edit user {{ $user->name }}</h3>

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

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
                        <input id="name" type="name" @cannot('restore', $user) readonly @endcannot class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="verified" class="col-md-2 col-form-label text-md-right"></label>

                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" name="verified" value="1" id="verified"
                                @if($user->hasVerifiedUser()) checked @endif>
                                <label class="form-check-label" for="verified">
                                    Verified user
                                </label>
                        </div>
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
                        <input id="first_name" name="first_name" type="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $user->first_name) }}" required>

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
                        <input id="last_name" name="last_name" type="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $user->last_name) }}" required>

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

                <button type="submit" class="btn btn-lg btn-success">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection
