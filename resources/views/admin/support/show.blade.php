@extends('layouts.admin')

@section('content')
<?php $auth_user_id = Auth::user()->id; ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Messages</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                @include('partials.alerts')

                <div class="row">
                    <div class="col-12">
                        <div class="card direct-chat direct-chat-primary">
                            <div class="card-header ui-sortable-handle">
                                <h3 class="card-title">{{ $thread->subject }}</h3>
                            </div>
                            <div class="card-body" style="display: block;">
                                <div class="direct-chat-messages">
                                    @forelse($thread->messages as $message)
                                        <div class="direct-chat-msg @if($message->user->id == $auth_user_id) right @endif">
                                            <div class="direct-chat-infos clearfix">
                                                <span class="direct-chat-name @if($message->user->id == $auth_user_id) float-right @else float-left @endif">{{ $message->user->name }}</span>
                                                <span class="direct-chat-timestamp @if($message->user->id == $auth_user_id) float-left @else float-right @endif">{{ $message->created_at->format('d M Y H:i:s') }}</span>
                                                {{-- <span class="direct-chat-timestamp float-right"></span> --}}
                                            </div>
                                            @if ($message->user->images->count() > 0)
                                                <img class="direct-chat-img" src="{{ asset('storage/'.$message->user->images->first()->link) }}" alt="{{ $message->user->name }}">
                                            @else
                                                <img class="direct-chat-img" src="{{ asset('images/site/no-photo-user.png') }}" alt="{{ $message->user->name }}">
                                            @endif
                                            <div class="direct-chat-text">
                                                {{ html_entity_decode($message->body) }}
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                            <div class="card-footer d-block">
                                <form action="{{ route('profile.supports.update', $thread) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group">
                                        <input type="text" name="message" placeholder="Type Message ..." mozactionhint="send" autofocus class="form-control @error('message') is-invalid @enderror">
                                        <span class="input-group-append">
                                            <button type="sumbit" class="btn btn-primary">Send</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
