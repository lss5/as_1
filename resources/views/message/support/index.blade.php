@extends('home.layout')

@section('content_p')

<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        {{-- Buttons --}}
        @include('partials.messages-navbar')

        @if ($threads->count() > 0)
            <div class="list-group">
                @forelse($threads as $thread)
                    <?php $auth_user_id = Auth::id(); ?>
                    <a href="{{ route('support.show', $thread) }}" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">
                                {{ Str::limit($thread->subject, 35, '...') }}
                                @if($thread->isUnread($auth_user_id)) <span class="badge badge-success">New</span> @endif
                            </h5>
                            @if ($thread->participants->count() > 1)
                                <small><i class="fas fa-headset"></i> {{ $thread->participantsString($auth_user_id) }}</small>
                            @endif
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
                                @if($thread->latestMessage->user->id == $auth_user_id)
                                    <span class="badge badge-secondary">In work</span>
                                @else
                                    <span class="badge badge-success">Answered</span>
                                @endif
                                @if ($thread->participants->count() < 2)
                                @else
                                @endif
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="alert alert-secondary" role="alert">
                <h4 class="alert-heading">No messages</h4>
                <p class="mb-0">For assistance, you can contact our customer <a href="{{ route('support.create') }}" class="alert-link">support center</a> for assistance.</p>
            </div>
        @endif
    </div>
    <div class="col-12 d-flex justify-content-center my-1">
        {{-- {{ $products->withQueryString()->links() }} --}}
    </div>
</div>
@endsection
    