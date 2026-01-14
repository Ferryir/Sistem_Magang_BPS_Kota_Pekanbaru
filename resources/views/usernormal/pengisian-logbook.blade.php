@extends('layouts.app')

@section('title', 'Logbook')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-6 gap-y-6">
        <!-- Start coding here -->
        <div>
            @livewire('add-logbook')
        </div>
    </div>
@endsection

