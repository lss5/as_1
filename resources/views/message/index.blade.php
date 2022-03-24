@extends('home.layout')

@section('content_p')
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
        <div class="col-sm-12">
            <div class="d-flex justify-content-between">
                <h1 class="h3">{{ __('Messages') }}</h1>
                <div class="m-0 p-0">
                    <form action="{{ route('home.messages.create') }}" id="help-request-form" method="GET" class="form-inline">
                        <input type="hidden" name="type" value="support">
                        <button type="submit" class="btn btn-sm btn-outline-success mx-1">
                            Help request <i class="fas fa-headset"></i>
                        </button>
                    </form>
                </div>
            </div>
            @if ($threads->count() > 0)
                <div class="list-group">
                    @forelse($threads as $thread)
                        <?php $auth_user_id = Auth::id(); ?>
                        <?php $unread = $thread->isUnread($auth_user_id); ?>
                        <a href="{{ route('home.messages.show', $thread) }}" class="list-group-item list-group-item-action @if($unread) list-group-item-dark @endif">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $thread->participantsString($auth_user_id) }}</h5>
                                <small>{{ Str::limit($thread->subject, 99, '...') }}</small>
                            </div>

                            <p class="mb-1">
                                @if($thread->latestMessage->user->id == $auth_user_id)
                                    <small class="text-muted">You:</small>
                                @else
                                    <small class="text-muted">{{ $thread->latestMessage->user->name }}:</small>
                                @endif
                                {{ html_entity_decode(Str::limit($thread->latestMessage->body, 99, '...')) }}
                            </p>

                            <div class="d-flex w-100 justify-content-between align-content-end">
                                <small>{{ $thread->latestMessage->created_at->diffForHumans() }}</small>
                                <p class="m-0 h6">
                                    @switch($thread->type)
                                        @case('product')
                                            <span class="badge badge-secondary">{{ App\Thread::$types[$thread->type] }}</span>
                                            @break
                                        @case('support')
                                            <span class="badge badge-success">{{ App\Thread::$types[$thread->type] }}</span>
                                            @break
                                        @case('person')
                                            <span class="badge badge-primary">{{ App\Thread::$types[$thread->type] }}</span>
                                            @break
                                        @case('plaint')
                                            <span class="badge badge-danger">Scammer</span>
                                            @break
                                        @default
                                            <span class="badge badge-warning">Error</span>
                                    @endswitch
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">No messages</h4>
                    <p>You have not sent or received any messages yet. You can start a dialogue with the seller by clicking the "send" button in the product card. After sending the message, the dialogue with the user will be available on this page.</p>
                    <hr>
                    <p class="mb-0">For assistance, you can contact our customer <a href="{{ route('home.messages.create') }}" class="alert-link" onclick="event.preventDefault(); document.getElementById('help-request-form').submit();">support center</a> for assistance.</p>
                </div>
            @endif
        </div>
        <div class="col-12 d-flex justify-content-center my-1">
            {{-- {{ $products->withQueryString()->links() }} --}}
        </div>
    </div>
@endsection
    