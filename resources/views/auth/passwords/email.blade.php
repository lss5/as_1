@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row my-3 justify-content-center">
        <div class="form-signin p-3 text-center">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <h1 class="h3 mb-3 font-weight-normal">{{ __('Reset Password') }}</h1>
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <label for="email" class="w-100">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror mb-2 rounded" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
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

                <button type="submit" class="btn btn-lg btn-primary btn-block">
                    {{ __('Send Password Reset Link') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
