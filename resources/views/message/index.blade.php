@extends('home.layout')

@section('content_p')
<div class="container">
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
            <h1 class="h3">{{ __('Messages') }}</h1>
            <div class="list-group">
                @forelse($threads as $thread)
                    <?php $unread = $thread->isUnread(Auth::id()); ?>
                    <a href="{{ route('home.messages.show', $thread) }}" class="list-group-item list-group-item-action @if($unread) list-group-item-success @endif">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ $thread->participantsString(Auth::id()) }}</h5>
                            <small>{{ $thread->latestMessage->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1">{{ $thread->latestMessage->body }}</p>
                        <small>{{ $thread->subject }}</small>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="col-12 d-flex justify-content-center my-1">
            {{-- {{ $products->withQueryString()->links() }} --}}
        </div>
    </div>
    @endsection
    