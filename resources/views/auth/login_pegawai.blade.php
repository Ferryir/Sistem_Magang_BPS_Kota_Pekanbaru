<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <title>Login Pegawai - Simag</title>
    @vite(['resources/css/app.css'])
    @livewireStyles
</head>

<body>

    <div class="flex flex-col lg:flex-row relative">
        <div class="m-0 p-0 w-full h-[100vh] relative gradient-overlay-login z-[0] basis-[65%]">
            <a href="{{ url('/') }}"
                class="w-fit text-gray-800 text-sm absolute flex items-center justify-center gap-4 top-5 md:top-10 left-4 md:left-10 px-5 py-2 bg-white hover:bg-gray-200 transition-all ease-in rounded-lg">
                <i class="fa-solid fa-arrow-left"></i>
                <p>kembali ke beranda</p>
            </a>
            <img src="{{ asset('assets/home/beranda/BPS.jpg') }}" alt="BPS image" class="object-cover w-full h-full">
        </div>
        <div
            class="relative px-5 py-5 md:px-20 md:py-10 flex flex-col items-center justify-center gap-7 z-10 basis-[35%]">
            <div class="flex w-full items-center justify-start md:justify-center">
                <img class="w-[70px]" src="{{ asset('assets/bps-logo.svg') }}" alt="BPS logo image">
            </div>
            <div class="flex flex-col w-full items-start gap-4 text-gray-800">
                <h1 class="font-semibold text-lg md:text-2xl">Selamat Datang di <br> Sistem Pengelolaan Magang </h1>
                <p class="font-normal text-sm">Masuk untuk menggunakan layanan</p>
            </div>
            <div class="w-full rounded-lg ">
                @livewire('login-pegawai')
            </div>
        </div>
    </div>

    @include('_message')

    @livewireScripts
</body>

</html>