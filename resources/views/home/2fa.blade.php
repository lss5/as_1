
@extends('home.layout')

@section('content_p')
<div class="row">
    <div class="col-md-12 col-xl-8 mb-3 mx-auto">
        <h1 class="h4">{{ __('2-Step Verification') }}</h1>
        <p>Two-step verification helps protect you by making it more difficult for someone else to sign in to your AsicSeller account. It uses two different forms of identity: your password, and a contact method (also known as security info). Even if someone else finds your password, they'll be stopped if they don't have access to your security info. This is also why it's important to use different passwords for all your accounts.</p>
        <form class="w-100" action="{{ route('home.f2a.store', $user) }}" method="POST">
            @csrf
            <img src="{{ $ga_url }}" alt="" class="img-fluid my-2 mx-auto d-block">
            <a href="otpauth://totp/{{ $ga_url }}" class="btn btn-lg btn-outline-success mx-auto d-block" style="max-width:200px">or Link</a>
            <div class="form-group">
                <label for="code">CODE</label>
                <input id="code" type="text" class="form-control" name="code" required>
                <small id="emailHelp" class="form-text text-muted">
                    As part of setting up this account, you’ll be given a QR code to scan with your device; this is one way we ensure you are in physical possession of the device you are installing the Authenticator app to. <a href="https://support.google.com/accounts/answer/1066447" target="_blank">Learn more about Google Authenticator</a>
                </small>
            </div>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <button type="submit" class="btn btn-success">Send</button>
        </form>
        
    </div>
</div>

@endsection
