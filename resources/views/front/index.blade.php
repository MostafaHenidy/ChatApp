@extends('layouts.app')

@section('content')
    @include('front.partials.sidebar')
    <main class="brutalist-card">
        <div class="brutalist-card__header">
            <h2>Welcome to {{ config('app.name') }}</h2>
        </div>
        <div class="brutalist-card__body">
            <p>Select a conversation to start chatting</p>
        </div>
    </main>
@endsection
