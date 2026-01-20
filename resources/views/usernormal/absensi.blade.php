@extends('layouts.app')

@section('title', 'Presensi')

@section('content')
    <div class="grid grid-cols-1 gap-6">
        <div class="col-span-1 card rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
            @livewire('absensi-form')
        </div>
    </div>
@endsection