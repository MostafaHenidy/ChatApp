@extends('layouts.app')

@section('content')
    <div class="chat-container">
        @include('front.partials.sidebar')
        <livewire:group-messages :group="$group" :messages="$messages" />
    </div>
@endsection
