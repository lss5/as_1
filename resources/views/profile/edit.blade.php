@extends('layouts.profile')

@section('content')
<div class="col-12 col-lg-8 mx-auto">
    <h1 class="h4 my-2">{{ __('home.pages.edit') }}</h1>
    <hr class="py-1">
    <form class="w-100" action="{{ route('profile.update', $user) }}" method="POST">
        @method('PATCH')
        @csrf
        <div class="row">
            <div class="col-sm-12 col-lg-3">
                <label for="email">{{ __('home.email.title') }}</label>
            </div>
            <div class="col-sm-12 col-lg-9 form-group">
                @error('email')
                    <small class="form-text text-danger">
                        {{ $message }}
                    </small>
                @enderror
                <input id="email" type="email" @cannot('forceDelete', $user) readonly @endcannot class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                <small class="form-text text-muted">{{ __('home.email.prompt') }}</small>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-3">
                <label for="username">{{ __('home.username.title') }}</label>
            </div>
            <div class="col-sm-12 col-lg-9 form-group">
                @error('username')
                    <small class="form-text text-danger">
                        {{ $message }}
                    </small>
                @enderror
                <input id="username" type="text" @cannot('restore', $user) readonly @endcannot class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                <small class="form-text text-muted">{{ __('home.username.prompt') }}</small>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-3">
                <label for="first_name">{{ __('home.first_name.title') }}</label>
            </div>
            <div class="col-sm-12 col-lg-9 form-group">
                @error('first_name')
                    <small class="form-text text-danger">
                        {{ $message }}
                    </small>
                @enderror
                <input id="first_name" name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $user->first_name) }}" required>
                <small class="form-text text-muted">{{ __('home.first_name.prompt') }}</small>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-3">
                <label for="last_name">{{ __('home.last_name.title') }}</label>
            </div>
            <div class="col-sm-12 col-lg-9 form-group">
                @error('last_name')
                    <small class="form-text text-danger">
                        {{ $message }}
                    </small>
                @enderror
                <input id="last_name" name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $user->last_name) }}" required>
                <small class="form-text text-muted">{{ __('home.last_name.prompt') }}</small>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-3">
                <label for="country">{{ __('home.country.title') }}</label>
            </div>
            <div class="col-sm-12 col-lg-9 form-group">
                @error('country')
                    <small class="form-text text-danger">
                        {{ $message }}
                    </small>
                @enderror
                <select name="country" id="country" required class="custom-select @error('country') is-invalid @enderror">
                    @foreach (App\Country::all() as $country)
                        <option value="{{ $country->id }}" @if(old('country') == $country->id || $user->country_id == $country->id) selected @endif>{{ $country->name }}</option>
                    @endforeach
                </select>
                <small class="form-text text-muted">{{ __('home.country.prompt') }}</small>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" onclick='return confirm("Save change?");' class="btn btn-outline-success">{{ __('home.btn.save') }}</button>
            </div>
        </div>
    </div>
</form>
</div>
@endsection
