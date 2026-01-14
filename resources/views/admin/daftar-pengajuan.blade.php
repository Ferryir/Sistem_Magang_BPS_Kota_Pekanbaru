@extends('layouts.admin')

@section('title', 'Daftar Pengajuan')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-4 lg:gap-x-6 gap-x-0 lg:gap-y-6 gap-y-6">

        <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <div class="">
                <h4 class="text-gray-900 font-semibold text-2xl dark:text-white">
                    Daftar Pengajuan
                </h4>
            </div>
        </div>
        <!-- Start coding here -->
        <div class="col-span-4 card bg-white dark:bg-gray-800 relative sm:rounded-lg overflow-hidden">
            @livewire('show-daftar-pengajuan')
        </div>

    </div>
@endsection
