@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row my-3 justify-content-center">
        <div class="form-register p-3 text-center shadow-sm bg-white rounded">
            <h1 class="h3 mb-3 font-weight-normal">{{ __('Register New Account') }}</h1>
            <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="username-prepend"><i class="fas fa-at"></i></span>
                </div>
                <input required type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Username" aria-label="Username" aria-describedby="username-prepend" autofocus autocomplete="username">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="email-prepend"><i class="fas fa-envelope"></i></span>
                </div>
                <input required type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="E-mail" aria-label="email" aria-describedby="email-prepend" autocomplete="email">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="password-prepend"><i class="fas fa-lock"></i></span>
                </div>
                <input required id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="Password" aria-label="password" aria-describedby="password-prepend" autocomplete="new-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="new-password-prepend"><i class="fas fa-lock"></i></span>
                </div>
                <input required id="password-confirm" name="password_confirmation" type="password" class="form-control" placeholder="Confirm" aria-label="password" aria-describedby="new-password-prepend" autocomplete="new-password">
            </div>
            <div class="row">
                <div class="col pr-1">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="first-name-prepend"><i class="fas fa-user"></i></span>
                        </div>
                        <input required id="first_name" name="first_name" type="text" value="{{ old('first_name') }}" class="form-control @error('country') is-invalid @enderror" placeholder="First name" autocomplete="given-name" aria-label="First name" aria-describedby="first-name-prepend">
                    </div>
                </div>
                <div class="col pl-1">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="last-name-prepend"><i class="fas fa-user"></i></span>
                        </div>
                        <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" class="form-control" placeholder="Last name" autocomplete="given-name" aria-label="Last name" aria-describedby="last-name-prepend">
                    </div>
                </div>
                @error('first_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @error('last_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <select name="country" id="country" class="custom-select @error('country') is-invalid @enderror">
                <option value selected>Select a country</option>
                @foreach (App\Country::all() as $country)
                    <option value="{{ $country->id }}" @if(old('country') == $country->id) selected @endif>{{ $country->name }}</option>
                @endforeach
            </select>
            @error('country')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <div class="my-2 d-flex justify-content-center align-items-center flex-column">
                {!! NoCaptcha::renderJs() !!}
                {!! NoCaptcha::display() !!}
                @if ($errors->has('g-recaptcha-response'))
                    <span class="help-block text-danger">
                        <strong><small>{{ $errors->first('g-recaptcha-response') }}</small></strong>
                    </span>
                @endif
            </div>

            <button type="submit" class="btn btn-lg btn-success btn-block my-2">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</div>
@endsection
