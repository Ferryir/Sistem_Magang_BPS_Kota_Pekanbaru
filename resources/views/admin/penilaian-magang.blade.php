@extends('layouts.admin')

@section('title', 'Penilaian Magang')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-6 gap-y-6">
        <div class="col-span-1 card rounded-lg bg-white p-6 h-full dark:bg-[#14181b] transition-all duration-200">
            @livewire('penilaian-magang-form')
        </div>
    </div>
@endsection