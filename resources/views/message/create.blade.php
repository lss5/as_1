@extends('home.layout')

@section('content_p')
<?php $auth_user_id = Auth::user()->id; ?>

<div class="row justify-content-center">
    <div class="col-sm-12 col-lg-10">
        <div class="m-0 py-2 d-flex justify-content-between">
            <h1 class="h3 m-0">{{ __('New message') }}</h1>
            <div class="m-0 d-inline">
                @switch($type)
                    @case('product')
                        <a href="{{ route('products.show', $parent_id) }}" class="text-decoration-none text-reset h5 m-0">
                            <span class="badge badge-secondary">{{ App\Thread::$types[$type] }} <i class="fas fa-sm fa-external-link-alt"></i></span>
                        </a>
                        @break
                    @case('support')
                        @if($parent_id)
                            <a href="{{ route('products.show', $parent_id) }}" class="text-decoration-none text-reset h5 m-0">
                                <span class="badge badge-success">{{ App\Thread::$types[$type] }} with listing <i class="fas fa-sm fa-external-link-alt"></i></span>
                            </a>
                        @else
                            <p class="h4 m-0"><span class="badge badge-success">Help request<i class="fas fa-headset"></i></span></p>
                        @endif
                        @break
                    @case('person')
                        <a href="{{ route('products.user', $parent_id) }}" class="text-decoration-none text-reset h5 m-0">
                            <span class="badge badge-primary">{{ App\Thread::$types[$type] }} <i class="fas fa-sm fa-user-tie"></i></span>
                        </a>
                        @break
                    @case('plaint')
                        <a href="{{ route('products.show', $parent_id) }}" class="text-decoration-none text-reset h5 m-0">
                            <span class="badge badge-danger">{{ App\Thread::$types[$type] }} <i class="fas fa-sm fa-bell"></i></span>
                        </a>
                        @break
                    @default
                @endswitch
            </div>
        </div>
        @if ($errors->any())
            <ul class="list-group mb-2">
                @foreach ($errors->all() as $error)
                    <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <form method="POST" action="{{ route('home.messages.store') }}">
            @csrf
            @if($parent_id)
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
            @endif
            <input type="hidden" name="type" value="{{ $type }}">
            <!-- Subject Form Input -->
            <ul class="list-group">
                {{-- <li class="list-group-item p-2">{{ $subject }}</li> --}}
                <li class="list-group-item p-2">
                    <h4 class="m-0">to:
                        @if($participant->id != $auth_user_id)
                            {{ $participant->first_name.' '.$participant->last_name }} ({{ $participant->name }})
                        @endif
                    </h4>
                </li>
                <li class="list-group-item p-2">
                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="3" autofocus>{{ old('message') ?? '' }}</textarea>
                    <small id="textHelp" class="form-text text-muted">Describe your problem or question</small>
                </li>
            </ul>
            <button type="submit" class="btn btn-outline-success my-2" role="button" aria-pressed="true">Send</button>
            <a href="{{ route('home.messages.index') }}" class="btn btn-outline-secondary m-2" role="button" aria-pressed="false">Cancel</a>
        </form>
    </div>
</div>
@endsection