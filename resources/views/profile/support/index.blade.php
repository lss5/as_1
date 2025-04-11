@extends('layouts.admin')

@section('content')
<?php $auth_user_id = Auth::user()->id; ?>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Help requests</h1>
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
                                <div class="d-flex justify-content-between align-items-center h4 m-0">
                                    <h3 class="card-title">Dialogs</h3>
                                    <a href="{{ route('profile.supports.create') }}" class="btn btn-sm btn-success">Create</a>
                                </div>
                            </div>
                            <div class="direct-chat-contacts-old bg-dark">
                                @forelse($threads as $thread)
                                    <ul class="contacts-list">
                                        <li>
                                            <a href="{{ route('profile.supports.show', $thread) }}">
                                                <img class="contacts-list-img" src="{{ asset('images/common/no-photo-user.png') }}" alt="User Avatar">
                                                <div class="contacts-list-info">
                                                    <span class="contacts-list-name">{{ $thread->latestMessage->user->name }}
                                                        <small class="contacts-list-date float-right">{{ $thread->latestMessage->created_at->diffForHumans() }}</small>
                                                    </span>
                                                    <span class="contacts-list-msg">{{ html_entity_decode(Str::limit($thread->latestMessage->body, 99, '...')) }}</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                @empty
                                    <ul class="contacts-list">
                                        <li>
                                            <a href="#">


                                                <div class="contacts-list-info">
                                                    <span class="contacts-list-name">
                                                        No messages
                                                    </span>
                                                    <span class="contacts-list-msg">You have not sent or received any messages yet. You can start a dialogue with the seller by clicking the "send" button in the product card. After sending the message, the dialogue with the user will be available on this page.</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
