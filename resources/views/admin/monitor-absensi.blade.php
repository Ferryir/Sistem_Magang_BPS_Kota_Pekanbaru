@extends('layouts.admin')

@section('title', 'Monitor Presensi')

@section('content')
    <div class="grid grid-cols-1 gap-6">
        <div class="col-span-1 card rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
            <h4 class="text-gray-800 text-xl font-semibold mb-4 dark:text-white">
                <i class="ti ti-calendar-check mr-2"></i>Monitor Presensi Peserta Magang
            </h4>
            @livewire('monitor-absensi')
        </div>
    </div>
@endsection