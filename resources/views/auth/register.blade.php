@extends('layouts.auth')

@section('card')
<div class="card">
    <div class="card-body register-card-body">
        <p class="login-box-msg">Register a new membership</p>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="input-group mb-2">
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"  value="{{ old('name') }}" placeholder="Username">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
                @error('name')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group mb-2">
                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"  value="{{ old('first_name') }}" placeholder="First name">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
                @error('first_name')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group mb-2">
                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"  value="{{ old('last_name') }}" placeholder="Last name">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
                @error('last_name')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group mb-2">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @error('email')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group mb-3">
                <select name="country" id="country" class="custom-select @error('country') is-invalid @enderror">
                    <option value selected>Select a country</option>
                    @foreach (App\Country::all() as $country)
                        <option value="{{ $country->id }}" @if (old('country') == $country->id) selected @endif>{{ $country->name }}</option>
                    @endforeach
                </select>
                @error('country')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group mb-2">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                @error('password')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group mb-3">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Retype password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                @error('password_confirmation')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="icheck-success">
                        <input value="1" type="checkbox" id="agreeTerms" name="terms" value="agree">
                        <label for="agreeTerms">
                            I agree to the <a href="#">terms</a>
                        </label>
                    </div>
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-success btn-block">{{ __('Register') }}</button>
                </div>
            </div>
        </form>

        <div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-primary">
                <i class="fab fa-facebook mr-2"></i>
                Sign up using Facebook
            </a>
            <a href="#" class="btn btn-block btn-danger">
                <i class="fab fa-google-plus mr-2"></i>
                Sign up using Google+
            </a>
        </div>

        <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
    </div>
</div>
@endsection
