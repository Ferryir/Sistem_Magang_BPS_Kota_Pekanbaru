@php
    if (Auth::check()) {
        $layout = 'layouts.app';
    } elseif (Auth::guard('pegawai')->check()) {
        $layout = 'layouts.admin';
    }
@endphp

@extends($layout)

@section('title', 'User Edit Password')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-4 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">

        <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <h4 class="text-gray-700 text-lg font-semibold mb-4 dark:text-white">
                Ubah Password
            </h4>
            <div
                class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-red-100 rounded-lg border text-red-700 border-red-700">
                <i class="ti ti-alert-triangle text-lg"></i>
                <p class="text-sm">Perhatikan kombinasi password kamu!</p>
            </div>
            <div class="md:px-[0%] md:pt-[2%] mt-3 md:mt-0">
                @livewire('ubah-password')
            </div>
        </div>

    </div>
@endsection
