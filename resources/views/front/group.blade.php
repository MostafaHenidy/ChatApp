@extends('layouts.app')

@section('content')
    @include('front.partials.sidebar')
    <div class="brutalist-main-content">
        <livewire:group-messages :group="$group" :messages="$messages" />
    </div>
@endsection
