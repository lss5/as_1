@extends('home.layout')

@section('content_p')
<?php $auth_user_id = Auth::user()->id; ?>

<div class="row justify-content-center">
    <div class="col-sm-12 col-lg-10">
        <div class="m-0 py-2 d-flex justify-content-between">
            <h1 class="h3 m-0">Message</h1>
            <div class="m-0 d-inline">
                @switch($thread->type)
                    @case('product')
                        <a href="{{ route('products.show', $thread->product) }}" class="text-decoration-none text-reset h5 m-0">
                            <span class="badge badge-secondary">{{ App\Thread::$types[$thread->type] }} <i class="fas fa-sm fa-external-link-alt"></i></span>
                        </a>
                        @break
                    @case('support')
                        @if($thread->product)
                            <a href="{{ route('products.show', $thread->product) }}" class="text-decoration-none text-reset h5 m-0">
                                <span class="badge badge-success">{{ App\Thread::$types[$thread->type] }} <i class="fas fa-sm fa-external-link-alt"></i></span>
                            </a>
                        @else
                            <p class="h4 m-0"><span class="badge badge-success">{{ $thread->subject }} <i class="fas fa-headset"></i></span></p>
                        @endif
                        @break
                    @default
                @endswitch
            </div>
        </div>

        <ul class="list-group">
            <li class="list-group-item p-2">
                <h4 class="m-0">to:
                    @foreach($thread->participants as $participant)
                        @if($participant->user->id != $auth_user_id)
                            {{ $participant->user->first_name.' '.$participant->user->last_name }} ({{ $participant->user->name }})
                        @endif
                    @endforeach
                </h4>
            </li>
            @switch($thread->type)
                @case('product')
                    <li class="list-group-item p-0 d-flex justify-content-start">
                        <div class="w-25">
                            @if ($thread->product->images->count() > 0)
                                <img src="{{ asset('storage/'.$thread->product->images->first()->link) }}" alt="{{ $thread->product->title }}" class="img img-fluid">
                            @else
                                <img src="{{ asset('img/product-no-image.png') }}" alt="{{ $thread->product->title }}" class="img img-fluid">
                            @endif
                        </div>
                        <div class="w-75" style="border: 1px solid rgba(0, 0, 0, 0.125); border-width: 0px; border-left-width: 1px;">
                            <ul class="list-group list-group-flush w-100">
                                <li class="list-group-item p-1">
                                        {!! Str::limit($thread->product->title, 40, '') !!}
                                    </a>
                                </li>
                                <li class="list-group-item p-1">{{ $thread->product->price }} $</li>
                                <li class="list-group-item p-1">{{ $thread->product->hashrate }} {{ App\Product::$hashrates[$thread->product->hashrate_name] }}</li>
                                <li class="list-group-item p-1">{{ $thread->product->power }} W</li>
                                <li class="list-group-item p-1">{{ $thread->product->moq }} MOQ</li>
                            </ul>
                        </div>
                    </li>
                    @break

                @case('support')
                    {{-- <button class="btn btn-outline-success">
                        {{ App\Thread::$types[$thread->type] }}
                    </button> --}}
                    @break

                @default
            @endswitch

            <li class="list-group-item p-2 ">
                <form action="{{ route('home.messages.update', $thread->id) }}" method="post" class="form-inline">
                    @csrf
                    @method('PUT')
                    <div class="col-10 px-0">
                        <textarea name="message" placeholder="Write a message..." class="form-control w-100 @error('message') is-invalid @enderror" autofocus>{{ old('message') ?? ''}}</textarea>
                    </div>
                    <div class="col-2 px-0 pl-2">
                        <button type="submit" class="btn btn- btn-primary d-block w-100">Send</button>
                    </div>
                </form>
            </li>
            @forelse($thread->messages as $message)
                <li class="list-group-item text-decoration-none p-2 px-3 @if($message->user->id == $auth_user_id) list-group-item @endif">
                    <div class="d-flex w-100 flex-column
                        @if($message->user->id == $auth_user_id) align-items-end @else align-items-start @endif">
                        {{-- <h5 class="mb-1">{{ $message->user->name }}</h5> --}}
                        <small class="text-muted">@if($message->user->id == $auth_user_id) You @else {{ $message->user->name }} @endif</small>
                        <p class="mb-1 @if($message->user->id == $auth_user_id) text-right @else text-left @endif">{{ html_entity_decode($message->body) }}</p>
                        <small class="text-muted mt-1">{{ $message->created_at->diffForHumans() }}</small>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
    