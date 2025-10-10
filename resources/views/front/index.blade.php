@extends('layouts.app')

@section('content')
    <div class="chat-container">
        @include('front.partials.sidebar')
        <main class="main-content">
            <div class="welcome-screen">
                <div class="welcome-content">
                    <h2>Welcome to {{ config('app.name') }}</h2>
                    <p>Select a conversation to start chatting</p>
                </div>
            </div>
        </main>
    </div>
@endsection
