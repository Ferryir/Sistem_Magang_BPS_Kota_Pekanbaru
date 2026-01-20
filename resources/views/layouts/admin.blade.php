<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Favicon icon-->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css" />
    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @yield('head')

    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/dashboard.js'])
    @livewireStyles
</head>

@php
    $firstLetter = strtoupper(substr(Auth::guard('pegawai')->user()->name, 0, 1));
@endphp

<body class="bg-[#f8f9fa] dark:bg-[#0f1214] transition-all duration-200">

    @include('_message')

    <div class="flex p-5 xl:pr-0">
        <!-- -------------- -->
        <!-- Layout Sidebar -->
        <!-- -------------- -->
        <aside id="application-sidebar-brand"
            class="hs-overlay hs-overlay-open:translate-x-0 dark:bg-[#14181b] -translate-x-full transform hidden xl:block xl:translate-x-0 xl:end-auto xl:bottom-0 fixed xl:top-5 xl:left-auto top-0 left-0 with-vertical h-screen z-[999] shrink-0 w-[270px] card rounded-none lg:rounded-lg bg-white left-sidebar transition-all duration-200">
            <div class="p-4 flex justify-between items-center">
                <a href="/" class="text-nowrap flex">
                    <div class="flex items-center justify-start md:justify-center border-transparent">
                        <img class="mr-1" src="{{ asset('assets/bps-logo.svg') }}" alt="BPS logo image">
                        {{-- <h1 class="text-3xl font-medium font-sans italic text-[#2D95C9]">Simagang</h1> --}}
                    </div>
                </a>
            </div>
            <div class="scroll-sidebar" data-simplebar="">
                <nav class="w-full flex flex-col sidebar-nav px-4 mt-5">
                    <ul id="sidebarnav" class="text-gray-600 text-sm">
                        <li class="text-xs font-bold pb-[5px]">
                            <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                            <span class="text-xs text-gray-600 font-semibold">HOME</span>
                        </li>

                        <li class="sidebar-item">
                            <a class="pjax-link menu-item gap-3 py-2 my-1 text-[14px] flex items-center justify-start relative rounded-md w-full transition-all duration-200 hover:text-blue-700"
                                href="/">
                                <i class="ti ti-home ps-2 text-xl"></i>
                                <span>Beranda</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="pjax-link menu-item gap-3 py-2 my-1 text-[14px] flex items-center justify-start relative rounded-md w-full transition-all duration-200 hover:text-blue-700"
                                href="/dashboard-admin">
                                <i class="ti ti-layout-dashboard ps-2 text-xl"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="text-xs font-bold pb-[5px] mt-6">
                            <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                            <span class="text-xs text-gray-600 font-semibold">MENU</span>
                        </li>

                        <li class="sidebar-item">
                            <a class="pjax-link menu-item gap-3 py-2 my-1 text-[14px] flex items-center justify-start relative rounded-md w-full transition-all duration-200 hover:text-blue-600"
                                href="/daftar-pengajuan">
                                <i class="ti ti-list-check ps-2 text-xl"></i>
                                <span class="whitespace-nowrap">Daftar Pengajuan</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="pjax-link menu-item gap-3 py-2 my-1 text-[14px] flex items-center justify-start relative rounded-md w-full transition-all duration-200 hover:text-blue-600"
                                href="/monitor-absensi">
                                <i class="ti ti-calendar-check ps-2 text-xl"></i>
                                <span class="whitespace-nowrap">Monitor Presensi</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="pjax-link menu-item gap-3 py-2 my-1 text-[14px] flex items-center justify-start relative rounded-md w-full transition-all duration-200 hover:text-blue-600"
                                href="/penilaian-magang">
                                <i class="ti ti-certificate ps-2 text-xl"></i>
                                <span class="whitespace-nowrap">Penilaian Magang</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="menu-item gap-3 py-2 my-1 text-[14px] flex items-center justify-start relative rounded-md w-full transition-all duration-200 hover:text-blue-600"
                                href="/logout">
                                <i class="ti ti-logout ps-2 text-xl"></i>
                                <span>Keluar</span>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>
        <!-- -------------- -->
        <!-- Layout Main -->
        <!-- -------------- -->
        <div class="w-full page-wrapper xl:px-6 px-0">
            <!-- Main Content -->
            <main class="h-full max-w-full">
                <div class="full-container p-0 flex flex-col gap-6">
                    <!-- -------------- -->
                    <!-- Layout Header -->
                    <!-- -------------- -->
                    <div class="flex gap-[23px] sticky top-5 z-50">
                        <div
                            class="bg-white dark:bg-[#14181b] lg:flex items-center justify-center px-5 rounded-lg card hidden transition duration-200">
                            <button id="toggle-sidebar" class="text-gray-700 dark:text-white hover:text-blue-600">
                                <i class="ti ti-menu-2 text-xl"></i>
                            </button>
                        </div>
                        <header
                            class="bg-white card rounded-lg w-full text-sm py-4 px-6 transition-all duration-200 dark:bg-[#14181b]">
                            <!-- ========== HEADER ========== -->
                            <nav class="w-full h-full flex items-center justify-between" aria-label="Global">
                                <div class="text-xl dark:text-white max-xl:hidden flex items-center gap-3">
                                    <h1>Halo! <span
                                            class="font-medium">{{ Auth::guard('pegawai')->user()->name }}</span></h1>
                                    <img src="https://raw.githubusercontent.com/MartinHeinz/MartinHeinz/master/wave.gif"
                                        width="28px">
                                </div>
                                <ul class="icon-nav flex items-center gap-4">
                                    <li class="relative xl:hidden dark:text-white">
                                        <a class="text-xl icon-hover cursor-pointer text-heading" id="headerCollapse"
                                            data-hs-overlay="#application-sidebar-brand"
                                            aria-controls="application-sidebar-brand" aria-label="Toggle navigation"
                                            href="javascript:void(0)">
                                            <i class="ti ti-menu-2 relative z-1"></i>
                                        </a>
                                    </li>
                                </ul>
                                <div class="flex gap-4">
                                    {{-- Dark Mode Dinonaktifkan untuk sementara --}}
                                    {{-- <button id="theme-toggle" type="button"
                                        class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z">
                                            </path>
                                        </svg>
                                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                                fill-rule="evenodd" clip-rule="evenodd"></path>
                                        </svg>
                                    </button> --}}
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="hs-dropdown relative inline-flex [--placement:bottom-right] sm:[--trigger:hover]">
                                            @if (!empty(Auth::user()->foto_profil))
                                                <a
                                                    class="relative hs-dropdown-toggle cursor-pointer align-middle rounded-full">
                                                    <img id="" src="{{ Storage::url(Auth::user()->foto_profil) }}"
                                                        alt="Preview Foto Profil"
                                                        class="w-9 h-9 object-cover rounded-full outline outline-blue-600"
                                                        aria-hidden="true">
                                                </a>
                                            @else
                                                <a
                                                    class="relative hs-dropdown-toggle cursor-pointer align-middle rounded-full bg-blue-600">
                                                    <h1
                                                        class="object-cover font-regular text-white text-lg w-9 h-9 flex items-center justify-center">
                                                        {{ $firstLetter }}
                                                    </h1>
                                                </a>
                                            @endif
                                            <div class="card hs-dropdown-menu transition-[opacity,margin] rounded-md duration hs-dropdown-open:opacity-100 opacity-0 mt-2 w-[300px] md:w-[350px] hidden z-[12] bg-white dark:bg-gray-800"
                                                aria-labelledby="hs-dropdown-custom-icon-trigger">
                                                <div class="rounded-md overflow-hidden flex flex-col gap-2">
                                                    <div class="w-full h-20 bg-blue-400 relative">
                                                        <img class="absolute inset-0 w-full h-full object-cover"
                                                            src="{{ asset('assets/images/usernormal/bg-dash.svg') }}"
                                                            alt="">
                                                    </div>
                                                    <div
                                                        class="flex items-center gap-4 mx-4 -mt-12 px-3 py-3 bg-white bg-opacity-30 backdrop-filter backdrop-blur-lg rounded-md shadow">
                                                        @if (!empty(Auth::user()->foto_profil))
                                                            <img id="" src="{{ Storage::url(Auth::user()->foto_profil) }}"
                                                                alt="Preview Foto Profil"
                                                                class="w-12 h-12 object-cover rounded-lg outline outline-blue-600">
                                                        @else
                                                            <h1
                                                                class="w-12 h-12 flex items-center justify-center text-xl text-white bg-blue-600 rounded-lg">
                                                                {{ $firstLetter }}
                                                            </h1>
                                                        @endif
                                                        <div>
                                                            <p class="text-lg text-gray-800 font-medium">
                                                                {{ Auth::guard('pegawai')->user()->name }}
                                                            </p>
                                                            @if (Auth::guard('pegawai')->user()->role_temp == 'admin')
                                                                <p class="text-[12px] text-gray-600">Admin</p>
                                                            @else
                                                                <p class="text-[12px] text-gray-600">Pembimbing</p>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <a href="/ubah-password-admin"
                                                        class="pjax-link flex justify-between items-center font-normal px-5 py-1 rounded-md transition duration-300 hover:text-blue-600">
                                                        <div class="flex gap-3 items-center">
                                                            <i
                                                                class="ti ti-lock-exclamation text-xl text-green-400"></i>
                                                            <p class="text-sm">Ganti Password</p>
                                                        </div>
                                                        <i class="ti ti-chevron-right"></i>
                                                    </a>

                                                    <span class="w-full border-b border-gray-200"></span>

                                                    <a href="/logout"
                                                        class="flex gap-1 w-fit items-center font-normal px-3 py-1 ml-4 mb-4 mt-3 rounded-md transition duration-300 bg-blue-600 text-white hover:bg-blue-700">
                                                        <i class="ti ti-logout text-xl"></i>
                                                        <p class="text-sm">Keluar</p>
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </nav>

                            <!-- ========== END HEADER ========== -->
                        </header>
                    </div>

                    <!-- -------------- -->
                    <!-- Content -->
                    <!-- -------------- -->
                    <div id="pjax-container">
                        @yield('content')
                        <div id="loader"
                            class="hidden w-full fixed inset-0 flex items-center justify-center bg-gray-300 bg-opacity-50 z-[1000] lg:z-20">
                            <img src="{{ asset('assets/loader-dash.svg') }}" class="img-loader max-w-16 rounded-lg"
                                alt="Loading...">
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>


    <!-- Add your scripts here -->
    @livewireScripts
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/iconify-icon/dist/iconify-icon.min.js') }}"></script>
    <script src="{{ asset('assets/libs/@preline/dropdown/index.js') }}"></script>
    <script src="{{ asset('assets/libs/@preline/overlay/index.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
    <script>
        $(document).pjax('a.pjax-link', '#pjax-container', {
            fragment: '#pjax-container',
            timeout: 8000
        });

        $(document).on('pjax:send', function () {
            // Show the loader
            $('#loader').removeClass('hidden');
        });

        $(document).on('pjax:complete', function () {
            // Hide the loader
        });

        $('a.pjax-link').on('click', function (e) {
            var targetUrl = $(this).attr('href');

            if (window.location.pathname === targetUrl) {
                e.preventDefault();
            }
        });
    </script>

</body>