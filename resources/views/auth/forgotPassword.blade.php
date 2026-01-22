<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <title>Lupa Password - Simag</title>
    @vite(['resources/css/app.css'])
    @livewireStyles
</head>

<body>

    <div class="flex flex-col lg:flex-row relative">
        <div class="m-0 p-0 w-full h-[100vh] relative gradient-overlay-login z-[0] basis-[65%]">
            <img src="{{ asset('assets/home/beranda/BPS.jpg') }}" alt="BPS image" class="object-cover w-full h-full">
        </div>
        <div
            class="relative px-5 py-5 md:px-20 md:py-10 flex flex-col items-center justify-center gap-7 z-10 basis-[35%]">
            <div class="flex w-full items-center justify-start md:justify-center md:mb-7">
                <img class="w-[90px]" src="{{ asset('assets/bps-logo.svg') }}" alt="BPS logo image">
            </div>
            <div class="flex flex-col w-full items-start gap-2 text-gray-800">
                <h1 class="font-semibold text-lg md:text-2xl">Reset Password</h1>
                <p class="font-normal text-sm">Masuk email kamu untuk mereset password</p>
            </div>
            <div class="w-full rounded-lg ">
                @livewire('forgot-password')
            </div>
        </div>
    </div>

    @include('_message')

    @livewireScripts
</body>

</html>