@extends('layouts.app')

@section('title', 'Upload Surat Pengantar')

@section('content')
    <div class="w-full h-44 rounded-lg bg-blue-500 relative overflow-hidden">
        <img class="absolute inset-0 w-full h-full object-cover" src="{{ asset('assets/images/usernormal/bg-dash.svg') }}"
            alt="">
        <p class="flex h-full w-full px-6 items-center justify-start text-white text-xl md:text-3xl font-normal">Selamat
            datang di<span class="font-medium ml-1 md:ml-2 z-10">SIMAGANG</span></p>
    </div>

    <div class="grid grid-cols-1 mt-6 lg:grid-cols-3 lg:gap-x-6 gap-x-0 gap-y-6">
        @if (Auth::user()->pengajuan()->where('status_pengajuan', 'accept-first')->exists())
            @php
                $pengajuan = Auth::user()->pengajuan()->where('status_pengajuan', 'accept-first')->first();
            @endphp
                <div class="col-span-3 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                    <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-red-100 rounded-lg border text-red-700 border-red-700">
                        <i class="ti ti-alert-triangle text-lg"></i>
                        <p class="text-sm"><span class="font-semibold">Peringatan: </span>Surat pengantar tidak valid / tidak jelas dapat menyebabkan pengajuan kamu ditolak</p>
                    </div>
                </div>
        @endif
    </div>

    <div class="grid grid-cols-1 mt-6 lg:grid-cols-3 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
        <div class="col-span-3 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <ol class="flex items-center w-full px-[5%] md:px-[15%]">
                <li
                    class="step1-active flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:bg-gray-100 after:inline-block">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0"
                        data-tooltip-target="tooltip-profil">
                        <i class="ti ti-user text-2xl text-gray-500 "></i>
                    </span>
                    <div id="tooltip-profil" role="tooltip"
                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-regular text-gray-600 transition-opacity duration-300 bg-white rounded-lg shadow-lg opacity-0 tooltip dark:bg-gray-700">
                        Melengkapi Profil
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </li>
                <li
                    class="step2-active flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:bg-gray-100 after:inline-block">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0"
                        data-tooltip-target="tooltip-pengajuan">
                        <i class="ti ti-clipboard-text text-2xl text-gray-500"></i>
                    </span>
                    <div id="tooltip-pengajuan" role="tooltip"
                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-regular text-gray-600 transition-opacity duration-300 bg-white rounded-lg shadow-lg opacity-0 tooltip dark:bg-gray-700">
                        Mengajukan Program Magang
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </li>
                <li
                    class="step3-active flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:bg-gray-100 after:inline-block">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0"
                        data-tooltip-target="tooltip-diterima">
                        <i class="ti ti-clipboard-check text-2xl text-gray-500"></i>
                    </span>
                    <div id="tooltip-diterima" role="tooltip"
                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-regular text-gray-600 transition-opacity duration-300 bg-white rounded-lg shadow-lg opacity-0 tooltip dark:bg-gray-700">
                        Lolos Seleksi Program
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </li>
                <li class="step4-active flex items-center w-fit">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0"
                        data-tooltip-target="tooltip-surat-pengantar">
                        <i class="ti ti-file-info text-2xl text-gray-500"></i>
                    </span>
                    <div id="tooltip-surat-pengantar" role="tooltip"
                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-regular text-gray-600 transition-opacity duration-300 bg-white rounded-lg shadow-lg opacity-0 tooltip dark:bg-gray-700">
                        Mengupload Surat Pengantar
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </li>
            </ol>
            <div>
                @livewire('upload-surat-pengantar')
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (Auth::user()->tentang_saya != null &&
                    Auth::user()->jenis_kelamin != null &&
                    Auth::user()->tempat_lahir != null &&
                    Auth::user()->tanggal_lahir != null &&
                    Auth::user()->alamat != null &&
                    Auth::user()->kartu_penduduk != null)
                var step1 = document.querySelector('.step1-active');
                if (step1) {
                    var span = step1.querySelector('span');
                    var div = step1.querySelector('#tooltip-profil');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                        div.classList.remove('bg-white');
                        div.classList.add('bg-blue-600');
                        div.classList.remove('text-gray-600');
                        div.classList.add('text-white');
                    }
                    var icon = step1.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
            @endif
            @if (Auth::user()->pengajuan()->exists() && Auth::user()->status_magang == 'masa-daftar')
                var step1 = document.querySelector('.step1-active');
                var step2 = document.querySelector('.step2-active');
                if (step1) {
                    step1.classList.remove('after:border-gray-100', 'after:bg-gray-100');
                    step1.classList.add('after:border-blue-600', 'after:bg-blue-600');
                    var span = step1.querySelector('span');
                    var div = step1.querySelector('#tooltip-profil');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                        div.classList.remove('bg-white');
                        div.classList.add('bg-blue-600');
                        div.classList.remove('text-gray-600');
                        div.classList.add('text-white');
                    }
                    var icon = step1.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
                if (step2) {
                    var span = step2.querySelector('span');
                    var div = step2.querySelector('#tooltip-pengajuan');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                        div.classList.remove('bg-white');
                        div.classList.add('bg-blue-600');
                        div.classList.remove('text-gray-600');
                        div.classList.add('text-white');
                    }
                    var icon = step2.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
            @endif
            @if (Auth::user()->pengajuan()->where('status_pengajuan', 'accept-first')->exists())
                var step2 = document.querySelector('.step2-active');
                var step3 = document.querySelector('.step3-active');
                if (step2) {
                    step2.classList.remove('after:border-gray-100', 'after:bg-gray-100');
                    step2.classList.add('after:border-blue-600', 'after:bg-blue-600');
                    var span = step2.querySelector('span');
                    var div = step2.querySelector('#tooltip-pengajuan');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                        div.classList.remove('bg-white');
                        div.classList.add('bg-blue-600');
                        div.classList.remove('text-gray-600');
                        div.classList.add('text-white');
                    }
                    var icon = step2.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
                if (step3) {
                    var span = step3.querySelector('span');
                    var div = step3.querySelector('#tooltip-diterima');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                        div.classList.remove('bg-white');
                        div.classList.add('bg-blue-600');
                        div.classList.remove('text-gray-600');
                        div.classList.add('text-white');
                    }
                    var icon = step3.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
            @endif
        });
    </script>
@endsection
