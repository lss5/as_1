@extends('home.layout')

@section('content_p')
<div class="container">
    <h1 class="h3">{{ __('New message') }}</h1>
    @if ($errors->any())
        <ul class="list-group mb-2">
            @foreach ($errors->all() as $error)
                <li class="list-group-item list-group-item-danger">{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <form method="POST" action="{{ route('home.messages.store') }}">
        @csrf
        <input type="hidden" name="parent_id" value="{{ $parent_id }}">
        <input type="hidden" name="type" value="{{ $type }}">
        <!-- Subject Form Input -->
        <div class="list-group">
            <a href="{{ route('products.show', $parent_id) }}" class="list-group-item list-group-item-action">{{ $subject }}</a>
            <a class="list-group-item text-decoration-none p-2">
                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="3">{{ old('message') ?? '' }}</textarea>
                <small id="textHelp" class="form-text text-muted">Describe your problem or question</small>
            </a>
        </div>
        <button type="submit" class="btn btn-outline-success my-2" role="button" aria-pressed="true">Send</button>
        <a href="{{ route('home.messages.index') }}" class="btn btn-outline-secondary m-2" role="button" aria-pressed="false">Cancel</a>
    </form>
</div>
@endsection