@extends('layouts.app')

@section('content')
    <div class="chat-container">
        @include('front.partials.sidebar')
        <livewire:chat-messages :friend="$friend" :messages="$messages" />
    </div>
@endsection
