@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        {{-- Buttons --}}
        @include('partials.messages-navbar')

        @if ($threads->count() > 0)
            <div class="list-group">
                @forelse($threads as $thread)
                    <?php $auth_user_id = Auth::id(); ?>
                    <a href="{{ route('messages.show', $thread) }}" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">
                                {{ Str::limit($thread->subject, 35, '...') }}
                                @if($thread->isUnread($auth_user_id)) <span class="badge badge-success">New</span> @endif
                            </h5>
                            <small><i class="fas fa-user"></i> {{ $thread->participantsString($auth_user_id) }}</small>
                        </div>

                        <p class="mb-1">
                        @isset($thread->latestMessage->user->id)
                            @if($thread->latestMessage->user->id == $auth_user_id)
                                <small class="text-muted">You:</small>
                            @else
                                <small class="text-muted">{{ $thread->latestMessage->user->name }}:</small>
                            @endif
                        @endisset
                            {{ html_entity_decode(Str::limit($thread->latestMessage->body, 99, '...')) }}
                        </p>

                        <div class="d-flex w-100 justify-content-between align-content-end">
                            <small>{{ $thread->latestMessage->created_at->diffForHumans() }}</small>
                            <p class="m-0 h6">
                                @if ($thread->latestMessage->user->hasAnyRoles(['admin', 'moder']))
                                    <span class="badge badge-success">Answered</span>
                                @endif
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">No messages</h4>
            </div>
        @endif
    </div>
    <div class="col-12 d-flex justify-content-center my-1">
        {{-- {{ $products->withQueryString()->links() }} --}}
    </div>
</div>
@endsection
    