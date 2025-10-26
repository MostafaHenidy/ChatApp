@extends('layouts.app')

@section('content')
    <div class="chat-container">
        @include('front.partials.sidebar')
        <livewire:group-management :group="$group" :messages="$messages" />
    </div>
@endsection
