@extends('home.layout')

@section('content_p')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-lg-10">
            <?php $auth_user_id = Auth::user()->id; ?>
            <h1 class="h3">
                @foreach($thread->participants as $participant)
                    @if($participant->user->id != $auth_user_id)
                        {{ $participant->user->first_name.' '.$participant->user->last_name }} ({{ $participant->user->name }})
                    @endif
                @endforeach
            </h1>
            {{-- <h1 class="h3">{{ $thread->subject }}</h1> --}}
            <ul class="list-group">
                @forelse($thread->messages as $message)
                    <li class="list-group-item text-decoration-none p-2 px-3 @if($message->user->id == $auth_user_id) list-group-item @endif">
                        <div class="d-flex w-100 flex-column
                            @if($message->user->id == $auth_user_id) align-items-end @else align-items-start @endif">
                            {{-- <h5 class="mb-1">{{ $message->user->name }}</h5> --}}
                            <small class="text-muted">{{ $message->user->name }}</small>
                            <p class="mb-1 @if($message->user->id == $auth_user_id) text-right @else text-left @endif">{{ $message->body }}</p>
                            <small class="text-muted mt-1">{{ $message->created_at->diffForHumans() }}</small>
                        </div>
                    </li>
                @endforeach
                <li class="list-group-item p-2">
                    <form action="{{ route('home.messages.update', $thread->id) }}" method="post">
                        @csrf
                        @method('PUT')
        
                        <div class="form-group mb-2">
                            <textarea name="message" placeholder="Write a message..." class="form-control @error('message') is-invalid @enderror">{{ old('message') ?? ''}}</textarea>
                        </div>
                        <div class="form-group m-0">
                            <button type="submit" class="btn btn-lg btn-primary d-block ml-auto">Send</button>
                        </div>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    @endsection
    