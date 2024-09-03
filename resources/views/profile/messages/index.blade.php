@extends('layouts.profile')

@section('content')
{{-- <div class="container"> --}}
    {{-- <form method="GET" action="{{ route('products.index') }}" class="w-100">
        <div class="row my-2" id="collapseFilterButton">
            <div class="col-12">
                <div class="form-inline">
                    <button type="button" class="btn btn-sm btn-secondary" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="collapseFilter collapseFilterButton">
                        Filters <i class="fas fa-search fa-xs"></i>
                    </button>
                    <div class="input-group mx-2 w-auto">
                        <select class="custom-select custom-select-sm" id="order" name="order" aria-label="Sort">
                            @foreach (App\Product::$sorting as $key => $value)
                            <option value="{{ $key }}" @if($key == request()->get('order')) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-outline-secondary" type="submit">Sort</button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="row collapse multi-collapse @if($searchForm) show @endif" id="collapseFilter">
            @include('partials.search')
        </div>
    </form> --}}

    <div class="row">
        <div class="col-12 col-lg-8 mx-auto">
            {{-- Buttons --}}
            @include('partials.messages-navbar')

            @if ($threads->count() > 0)
                <div class="list-group">
                    @forelse($threads as $thread)
                        <?php $auth_user_id = Auth::id(); ?>
                        <a href="{{ route('profile.message.show', $thread) }}" class="list-group-item list-group-item-action">
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
                                    @if ($thread->type == 'support')
                                        <span class="badge badge-success">{{ App\Thread::$types[$thread->type] }}</span>
                                    @endif
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="alert alert-secondary" role="alert">
                    <h4 class="alert-heading">No messages</h4>
                    <p>You have not sent or received any messages yet. You can start a dialogue with the seller by clicking the "send" button in the product card. After sending the message, the dialogue with the user will be available on this page.</p>
                </div>
            @endif
        </div>
        <div class="col-12 d-flex justify-content-center my-1">
            {{-- {{ $products->withQueryString()->links() }} --}}
        </div>
    </div>
@endsection
    