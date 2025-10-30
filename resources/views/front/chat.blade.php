@extends('layouts.app')

@section('content')
    @include('front.partials.sidebar')
    <div class="brutalist-main-content">
        <livewire:chat-messages :friend="$friend" :messages="$messages" />
    </div>
@endsection
