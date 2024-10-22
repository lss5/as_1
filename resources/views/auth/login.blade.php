@extends('layouts.auth')

@section('card')
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="input-group mb-3">
                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
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
            <div class="row">
                <div class="col-8">
                    <div class="icheck-success">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">
                            Remember Me
                        </label>
                    </div>
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-success btn-block">Sign In</button>
                </div>
            </div>
        </form>

        <div class="social-auth-links text-center mb-3">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-success">
                <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
            </a>
            <a href="#" class="btn btn-block btn-danger">
                <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
            </a>
        </div>

        @if (Route::has('password.request'))
            <p class="mb-1">
                <a href="{{ route('password.request') }}">I forgot my password</a>
            </p>
        @endif
        @if (Route::has('register'))
            <p class="mb-0">
                <a href="{{ route('register') }}" class="text-center">{{ __('Register') }}</a>
            </p>
        @endif
    </div>
</div>
@endsection
