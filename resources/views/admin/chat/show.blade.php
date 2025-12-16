@extends('layouts.vertical', ['title' => 'Chat with ' . $user->name])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('chat.index') }}" class="btn btn-secondary btn-sm">
                            <i class="mdi mdi-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                    <h4 class="page-title">Chat with {{ $user->name }}</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="chat-conversation"
                            style="height: 500px; overflow-y: scroll; display: flex; flex-direction: column;">
                            <ul class="list-unstyled mb-0" id="chat-list">
                                @foreach($messages as $message)
                                    <li class="clearfix {{ $message->sender_type === 'admin' ? 'odd' : '' }}">
                                        <div class="chat-avatar">
                                            @if($message->sender_type === 'admin')
                                                <img src="/images/logo.png" class="rounded" alt="admin">
                                                <i>{{ $message->created_at->format('H:i') }}</i>
                                            @else
                                                @if($user->profile_image)
                                                    <img src="{{ Storage::url($user->profile_image) }}" class="rounded" alt="user">
                                                @else
                                                    <div class="avatar-sm">
                                                        <span class="avatar-title bg-primary-light text-primary rounded-circle">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <i>{{ $message->created_at->format('H:i') }}</i>
                                            @endif
                                        </div>
                                        <div class="conversation-text">
                                            <div class="ctext-wrap">
                                                <i>{{ $message->sender_type === 'admin' ? 'Admin' : $user->name }}</i>
                                                <p>{{ $message->message }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <form action="{{ route('chat.store', $user->id) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" name="message" class="form-control chat-input"
                                                placeholder="Enter your message..." required>
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit"
                                                class="btn btn-danger chat-send waves-effect waves-light">Send</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .chat-conversation .conversation-list {
            padding-left: 0;
            list-style: none;
        }

        .chat-conversation li {
            margin-bottom: 20px;
            position: relative;
            display: flex;
            align-items: flex-start;
        }

        .chat-conversation li.odd {
            flex-direction: row-reverse;
            text-align: right;
        }

        .chat-conversation .chat-avatar {
            margin: 0 10px;
            text-align: center;
        }

        .chat-conversation .chat-avatar img {
            width: 40px;
            height: 40px;
            border-radius: 100%;
        }

        .chat-conversation .chat-avatar i {
            font-size: 12px;
            font-style: normal;
        }

        .chat-conversation .conversation-text {
            display: inline-block;
            font-size: 14px;
            position: relative;
            max-width: 80%;
        }

        .chat-conversation .ctext-wrap {
            padding: 12px 20px;
            background-color: #f1f3fa;
            border-radius: 8px 8px 8px 0;
            position: relative;
            display: inline-block;
        }

        .chat-conversation li.odd .ctext-wrap {
            background-color: #eef2f7;
            border-radius: 8px 8px 0 8px;
            text-align: left;
        }

        .chat-conversation .ctext-wrap i {
            display: block;
            font-size: 12px;
            font-style: normal;
            font-weight: bold;
            color: #98a6ad;
            margin-bottom: 5px;
        }

        .chat-conversation .ctext-wrap p {
            margin: 0;
        }
    </style>

    <script>
        // Scroll to bottom on load
        window.onload = function () {
            var chatDiv = document.querySelector('.chat-conversation');
            chatDiv.scrollTop = chatDiv.scrollHeight;
        };
    </script>
@endsection