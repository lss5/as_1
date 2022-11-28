@extends('home.layout')

@section('content_p')
<?php $auth_user_id = Auth::user()->id; ?>

<div class="row d-flex justify-content-center">
    <div class="col-sm-12 col-lg-8">
        {{-- validation errors --}}
        @if ($errors->any())
            <ul class="list-group mb-2">
                @foreach ($errors->all() as $error)
                    <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('support.store') }}">
            @csrf
            <div class="form-group row">
                <label for="participants" class="col-sm-10 col-form-label"><strong>{{ __('support.page.create') }}</strong></label>
                {{-- <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="participants" value="{{ $participant->first_name.' '.$participant->last_name }} ({{ $participant->name }})">
                </div> --}}
            </div>
            <div class="form-group row">
                <label for="subject" class="col-sm-2 col-form-label"><strong>Subject</strong></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" id="subject" value="{{ old('subject') ?? '' }}">
                </div>
            </div>
            <ul class="list-group">
                {{-- <li class="list-group-item p-2">{{ $subject }}</li> --}}
                <li class="list-group-item p-2">
                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="3" autofocus>{{ old('message') ?? '' }}</textarea>
                    <small id="textHelp" class="form-text text-muted">Describe your problem or question</small>
                </li>
            </ul>
            <button type="submit" class="btn btn-success my-2" role="button" aria-pressed="true">Send <i class="fas fa-paper-plane"></i></button>
            <a href="{{ route('support.index') }}" class="btn btn-outline-secondary m-2" role="button" aria-pressed="false">Cancel</a>
        </form>
    </div>
</div>
@endsection