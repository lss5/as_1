@extends('layouts.profile')

@section('content')
<?php $auth_user_id = Auth::user()->id; ?>

<div class="row d-flex justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="m-0 py-2">
            <span class="h4 m-0">
                @foreach($thread->participants as $participant)
                    @if($participant->user->id != $auth_user_id)
                        {{ $participant->user->first_name.' '.$participant->user->last_name }} ({{ $participant->user->name }})
                    @endif
                @endforeach
            </span>
        </div>

        <ul class="list-group">
            <li class="list-group-item p-2 d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge badge-success">Subject</span>
                    <strong>{{ $thread->subject }}</strong>
                </div>
            </li>
            <li class="list-group-item p-2 ">
                <form action="{{ route('profile.support.update', $thread) }}" method="post" class="form-inline">
                    @csrf
                    @method('PUT')
                    <div class="col px-0">
                        <textarea name="message" placeholder="Write a message..." class="form-control w-100 @error('message') is-invalid @enderror" autofocus>{{ old('message') ?? ''}}</textarea>
                    </div>
                    <div class="col-auto px-0 pl-2">
                        <button type="submit" class="btn btn- btn-primary d-block w-100">
                            <i class="fas fa-reply"></i>
                        </button>
                    </div>
                </form>
            </li>
            <?php $prev_message_date = false; ?>
            @forelse($thread->messages as $message)
                @if($prev_message_date)
                    @if($message->created_at->day != $prev_message_date->day || $message->created_at->month != $prev_message_date->month || $message->created_at->year != $prev_message_date->year)
                        <li class="list-group-item text-decoration-none border-bottom-0 p-2 px-3 disabled">
                            <div class="d-flex w-100 flex-column align-items-center ">
                                <small class="text-muted">{{ $message->created_at->isoFormat('D MMM YYYY') }}</small>
                            </div>
                        </li>
                    @endif
                @else
                    <li class="list-group-item text-decoration-none border-bottom-0 p-2 px-3 disabled">
                        <div class="d-flex w-100 flex-column align-items-center ">
                            @if($message->created_at->day == now()->day)
                                <small class="text-muted">Today</small>
                            @else
                                <small class="text-muted">{{ $message->created_at->isoFormat('D MMM YYYY') }}</small>
                            @endif
                        </div>
                    </li>
                @endif
                <li class="list-group-item text-decoration-none p-2 px-3 @if($message->user->id == $auth_user_id) @endif">
                    <div class="d-flex w-100 flex-column
                        @if($message->user->id == $auth_user_id) align-items-end @else align-items-start @endif">
                        {{-- <h5 class="mb-1">{{ $message->user->name }}</h5> --}}
                        <small class="text-muted"></small>
                        <p class="mb-1 @if($message->user->id == $auth_user_id) text-right @else text-left @endif">{{ html_entity_decode($message->body) }}</p>
                            <small class="text-muted"><b>@if($message->user->id == $auth_user_id) You @else {{ $message->user->name }} @endif </b>{{ $message->created_at->isoFormat('HH:mm') }}</small>
                    </div>
                </li>
                <?php $prev_message_date = $message->created_at; ?>
            @endforeach
        </ul>
    </div>
</div>
@endsection
    