@extends('home.layout')

@section('content_p')
<?php $auth_user_id = Auth::user()->id; ?>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8 mx-auto">
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
                    @switch($thread->type)
                        @case('product')
                            {{-- <a href="{{ route('products.show', $thread->product) }}" class="text-decoration-none text-reset h5 m-0">
                                <span class="badge badge-secondary">{{ App\Thread::$types[$thread->type] }} <i class="fas fa-sm fa-external-link-alt"></i></span>
                            </a> --}}
                            {{-- {{ $thread->product->title }} --}}
                            @break
                        @case('support')
                            @if($thread->product)
                                {{-- <a href="{{ route('products.show', $thread->product) }}" class="text-decoration-none text-reset h5 m-0">
                                    <span class="badge badge-success">{{ App\Thread::$types[$thread->type] }} <i class="fas fa-sm fa-external-link-alt"></i></span>
                                </a> --}}
                                {{-- {{ $thread->product->title }} --}}
                            @else
                                <p class="h5 m-0"><span class="badge badge-success">{{ $thread->subject }} <i class="fas fa-headset"></i></span></p>
                            @endif
                            @break
                        @case('person')
                            <p class="h5 m-0"><span class="badge badge-primary">{{ $thread->subject }} <i class="fas fa-user-tie"></i></span></p>
                            @break
                        @case('plaint')
                            @if($thread->product)
                                <a href="{{ route('products.show', $thread->product) }}" class="text-decoration-none text-reset h5 m-0">
                                    <span class="badge badge-danger">Scammer <i class="fas fa-sm fa-external-link-alt"></i></span>
                                </a>
                                {{ Str::limit($thread->product->title, 45, '...') }}
                            @else
                                <p class="h5 m-0"><span class="badge badge-success">Scammer <i class="fas fa-headset"></i></span></p>
                            @endif
                            @break
                        @default
                    @endswitch
                </div>
                <div>
                    <form action="{{ route('home.messages.destroy', $thread) }}" method="POST" class="form-inline">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick='return confirm("Delete all messages?");'>
                            Delete <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </li>
            {{-- @switch($thread->type)
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
                    <button class="btn btn-outline-success">
                        {{ App\Thread::$types[$thread->type] }}
                    </button>
                    @break

                @default
            @endswitch --}}

            <li class="list-group-item p-2 ">
                <form action="{{ route('home.messages.update', $thread->id) }}" method="post" class="form-inline">
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
    