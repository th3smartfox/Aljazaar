@extends('layouts.vertical', ['title' => 'Chat'])

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4"
            style="background-image: url('/images/svg/card-bg.svg'); background-position: right center; background-repeat: no-repeat; background-size: contain;">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-1">Chat App</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="text-muted"
                                        href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Chat</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <i class="mdi mdi-message-text-outline display-1 text-primary"
                                style="opacity: 0.5; transform: rotate(-15deg); display: inline-block;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card chat-app-wrapper">
            <div class="row g-0 h-100">
                <!-- Left Sidebar: User List -->
                <div class="col-xl-3 col-lg-4 border-end chat-sidebar">
                    <div class="p-3 border-bottom">
                        <div class="search-box">
                            <input type="text" class="form-control" placeholder="Search contacts...">
                            <i class="mdi mdi-magnify search-icon"></i>
                        </div>
                    </div>

                    <div class="chat-user-list" data-simplebar>
                        <ul class="list-unstyled mb-0">
                            @forelse($users as $user)
                                <li class="chat-user-item {{ $activeUser && $activeUser->id === $user->id ? 'active' : '' }}">
                                    <a href="{{ route('chat.show', $user->id) }}" class="d-flex align-items-center">
                                        <div class="flex-shrink-0 chat-user-img online align-self-center me-2">
                                            @if($user->profile_image)
                                                <img src="{{ Storage::url($user->profile_image) }}" class="rounded-circle avatar-sm"
                                                    alt="user">
                                            @else
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-primary-light text-primary rounded-circle">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                            @endif
                                            {{-- <span class="user-status"></span> --}}
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="text-truncate font-14 mb-1">{{ $user->name }}</h5>
                                            <p class="text-truncate mb-0 font-12 text-muted">
                                                {{ $user->chatMessages()->latest()->first()->message ?? '' }}
                                            </p>
                                        </div>
                                        <div class="font-11 text-muted">
                                            {{ $user->chatMessages()->latest()->first()->created_at->format('H:i') ?? '' }}
                                            @if($user->unread_count > 0)
                                                <div class="badge bg-danger rounded-pill float-end mt-1">{{ $user->unread_count }}
                                                </div>
                                            @endif
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li class="p-3 text-center text-muted">No chats found.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Right Panel: Chat Area -->
                <div class="col-xl-9 col-lg-8 chat-content">
                    @if($activeUser)
                        <!-- Chat Header -->
                        <div class="p-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-2">
                                    @if($activeUser->profile_image)
                                        <img src="{{ Storage::url($activeUser->profile_image) }}" class="rounded-circle avatar-sm"
                                            alt="user">
                                    @else
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-primary-light text-primary rounded-circle">
                                                {{ strtoupper(substr($activeUser->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="font-15 mb-0">{{ $activeUser->name }}</h5>
                                    <p class="mb-0 text-muted font-12">{{ $activeUser->phone_number }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Chat Messages -->
                        <div class="chat-conversation p-3" id="chat-conversation">
                            <ul class="list-unstyled mb-0">
                                @foreach($messages as $message)
                                    <li class="clearfix {{ $message->sender_type === 'admin' ? 'odd' : '' }}">
                                        <div class="chat-avatar">
                                            @if($message->sender_type === 'admin')
                                                <img src="/images/logo.png" class="rounded" alt="admin">
                                            @else
                                                @if($activeUser->profile_image)
                                                    <img src="{{ Storage::url($activeUser->profile_image) }}" class="rounded" alt="user">
                                                @else
                                                    <div class="avatar-sm">
                                                        <span class="avatar-title bg-primary-light text-primary rounded-circle">
                                                            {{ strtoupper(substr($activeUser->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            @endif
                                            <i>{{ $message->created_at->format('H:i') }}</i>
                                        </div>
                                        <div class="conversation-text">
                                            <div class="ctext-wrap">
                                                <i>{{ $message->sender_type === 'admin' ? 'You' : $activeUser->name }}</i>
                                                <p>{{ $message->message }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Chat Input -->
                        <div class="p-3 border-top">
                            <form action="{{ route('chat.store', $activeUser->id) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <input type="text" name="message" class="form-control"
                                            placeholder="Type your message..." required>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary chat-send"><i
                                                class="mdi mdi-send"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="d-flex align-items-center justify-content-center h-100">
                            <div class="text-center">
                                <i class="mdi mdi-chat-processing-outline display-4 text-muted"></i>
                                <h4 class="mt-3">Select a user to start chatting</h4>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .chat-app-wrapper {
            height: calc(100vh - 240px);
            /* Adjust based on header/footer height */
            min-height: 500px;
            overflow: hidden;
        }

        .chat-sidebar {
            height: 100%;
            display: flex;
            flex-direction: column;
            background-color: #fff;
        }

        .chat-user-list {
            flex-grow: 1;
            overflow-y: auto;
        }

        .chat-user-item a {
            padding: 15px 20px;
            display: flex;
            color: #6c757d;
            border-bottom: 1px solid #f1f3fa;
            transition: all 0.3s;
        }

        .chat-user-item:hover a,
        .chat-user-item.active a {
            background-color: #f3f7f9;
            color: #3b83f6;
            /* Primary color */
        }

        .chat-content {
            height: 100%;
            display: flex;
            flex-direction: column;
            background-color: #fff;
        }

        .chat-conversation {
            flex-grow: 1;
            overflow-y: auto;
            background-color: #f5f7fb;
        }

        /* Chat Bubbles */
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
            width: 36px;
            height: 36px;
            border-radius: 50%;
        }

        .chat-conversation .chat-avatar i {
            font-size: 11px;
            font-style: normal;
            display: block;
            margin-top: 4px;
        }

        .chat-conversation .conversation-text {
            max-width: 75%;
        }

        .chat-conversation .ctext-wrap {
            padding: 12px 20px;
            background-color: #fff;
            border-radius: 0 15px 15px 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .chat-conversation li.odd .ctext-wrap {
            background-color: #3b83f6;
            /* Primary color */
            color: #fff;
            border-radius: 15px 0 15px 15px;
            text-align: left;
        }

        .chat-conversation .ctext-wrap i {
            display: block;
            font-size: 12px;
            font-style: normal;
            font-weight: bold;
            margin-bottom: 5px;
            color: #343a40;
        }

        .chat-conversation li.odd .ctext-wrap i {
            color: rgba(255, 255, 255, 0.8);
        }

        .chat-conversation .ctext-wrap p {
            margin: 0;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var chatDiv = document.getElementById('chat-conversation');
            if (chatDiv) {
                chatDiv.scrollTop = chatDiv.scrollHeight;
            }
        });
    </script>
@endsection