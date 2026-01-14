<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        document.documentElement.classList.add('js')
    </script>
    <title>Simagang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@if (Auth::check())
    @php
        $firstLetter = strtoupper(substr(Auth::user()->name, 0, 1));
    @endphp
@endif
@if (Auth::guard('pegawai')->check())
    @php
        $firstLetter = strtoupper(substr(Auth::guard('pegawai')->user()->name, 0, 1));
    @endphp
@endif

<body>

    @include('_message')

    {{-- Navbar section --}}
    <nav
        class="sticky top-0 px-[20px] md:px-[10%] py-3 w-full flex justify-between items-center bg-gradient-to-r from-blue-900 to-blue-500 z-[100]">
        <div class="flex gap-3">
            <div class="flex items-center justify-start md:justify-center border-r md:border-white border-transparent">
                <img class="w-[80%] mr-1" src="{{ asset('assets/bps-logo.svg') }}" alt="BPS logo image">
            </div>
            <div class="text-white hidden md:block">
                <h1 class="font-normal">Badan Pusat Statistik</h1>
                <p class="font-light">Kota Pekanbaru</p>
            </div>
        </div>
        <div class="hidden lg:flex items-center justify-center gap-7 text-white text-sm">
            <a href="#beranda" class="nav-link py-1">Beranda</a>
            <a href="#alur-pendaftaran" class="nav-link py-1">Alur Pendaftaran</a>
            @if (Auth::check())
                @if (!empty(Auth::user()->foto_profil))
                    <a href="{{ url('/dashboard') }}"
                        class="px-2 py-2 rounded-3xl flex items-center justify-center gap-3 bg-white text-blue-500">
                        <img src="{{ Storage::url(Auth::user()->foto_profil) }}" alt="Preview Foto Profil"
                            class="w-9 h-9 object-cover rounded-full outline outline-blue-600 cursor-pointer">
                        <p class="font-medium">{{ Str::limit(Auth::user()->name, 9, '...') }}</p>
                    </a>
                @else
                    <a href="{{ url('/dashboard') }}"
                        class="px-2 py-2 rounded-3xl flex items-center justify-center gap-2 bg-white text-blue-500">
                        <div
                            class="w-9 h-9 flex items-center text-lg justify-center rounded-full bg-blue-600 text-white cursor-pointer">
                            <h1>{{ $firstLetter }}</h1>
                        </div>
                        <p class="font-medium">{{ Str::limit(Auth::user()->name, 9, '...') }}</p>
                    </a>
                @endif
            @elseif(Auth::guard('pegawai')->check())
                <a href="{{ url('/dashboard-admin') }}"
                    class="px-2 py-2 rounded-3xl flex items-center justify-center gap-2 bg-white text-blue-500">
                    <div
                        class="w-9 h-9 flex items-center text-lg justify-center rounded-full bg-blue-600 text-white cursor-pointer">
                        <h1>{{ $firstLetter }}</h1>
                    </div>
                    <p class="font-medium">{{ Str::limit(Auth::guard('pegawai')->user()->name, 9, '...') }}</p>
                </a>
            @else
                <a href="{{ url('/login') }}"
                    class="px-5 py-3 rounded-3xl flex items-center justify-center gap-3 bg-white text-blue-500">
                    <i class="fas fa-user"></i>
                    <p class="font-medium">Masuk ke akun</p>
                </a>
            @endif
        </div>
        <div class="lg:hidden">
            <button id="menu-toggle" class="text-white focus:outline-none">
                <i id="menu-icon" class="fa-solid fa-bars fa-2x"></i>
            </button>
        </div>
    </nav>
    <div id="mobile-menu"
        class="hidden fixed lg:hidden rounded-b-lg py-3 w-[100vw] bg-gradient-to-r from-blue-900 to-blue-500 text-white text-sm flex items-center gap-5 justify-center flex-col z-30 overflow-hidden">
        <div class="border-b border-white text-white w-full py-3 text-center flex flex-col gap-3">
            <h1 class="font-regular text-[21px]">Badan Pusat Statistik</h1>
            <p class="font-light text-[16px]">Kota Pekanbaru</p>
        </div>
        <a href="#beranda" class="nav-link py-1">Beranda</a>
        <a href="#alur-pendaftaran" class="nav-link py-1">Alur Pendaftaran</a>
        <a href="#faqs" class="nav-link py-1">FAQs</a>
        @if (Auth::check())
            <a href="{{ url('/login') }}"
                class="px-2 py-2 rounded-3xl flex items-center justify-center gap-3 bg-white text-blue-500">
                <img src="{{ Storage::url(Auth::user()->foto_profil) }}" alt="Preview Foto Profil"
                    class="w-9 h-9 object-cover rounded-full outline outline-blue-600 cursor-pointer"
                    onclick="openPreview('{{ Storage::url(Auth::user()->foto_profil) }}')">
                <p class="font-medium">{{ Str::limit(Auth::user()->name, 15, '...') }}</p>
            </a>
        @else
            <a href="{{ url('/login') }}"
                class="px-5 py-3 mb-3 rounded-3xl flex items-center justify-center gap-3 bg-white text-blue-500">
                <i class="fas fa-user"></i>
                <p class="font-medium">Masuk ke akun</p>
            </a>
        @endif
    </div>

    {{-- Beranda section --}}
    <section id="beranda">
        <div class="m-0 p-0 w-full h-[100vh] absolute gradient-overlay z-[0] parallax-beranda">
            {{-- <img src="{{ asset('assets/home/beranda/BPS.jpg') }}" alt="BPS image"
                class="object-cover w-full h-full"> --}}
        </div>
        <div class="relative px-[20px] md:px-[10%] h-[75vh] flex flex-col items-end text-end justify-center gap-8">
            <h1 class="font-bold text-white text-[33px] md:text-[41px] lg:text-[54px] leading-snug delay-[300ms] duration-[600ms] taos:translate-x-[-200px] taos:opacity-0"
                data-taos-offset="100">Program Magang <br> Bersama Badan Pusat Statistik <br> Kota Pekanbaru</h1>
            <p class="font-light text-white text-[14px] md:text-[18px] delay-[600ms] duration-[600ms] taos:translate-x-[-200px] taos:opacity-0"
                data-taos-offset="100">Daftarkan diri untuk mengikuti program magang yang ditawarkan oleh <br> Badan
                Pusat Statistik Kota Pekanbaru. Kembangkan potensi diri <br> bersama statistisi berpengalaman.</p>
            <div
                >
                <a href="{{ Auth::check() ? '/dashboard' : '/login' }}"
                    class="rounded-[10px] w-full md:px-9 py-3 bg-blue-600 text-white text-[14px] whitespace-nowrap transition duration-300 ease-in-out hover:bg-blue-500">Daftar Sekarang</a>
            </div>
        </div>
    </section>

    {{-- Alur Pendaftaran Magang section --}}
    <section id="alur-pendaftaran" class="relative w-full h-fit px-4 py-10 md:px-[10%] md:py-16 bg-gray-100">
        <div class="text-center mb-12">
            <h1 class="text-[#373737] text-[26px] md:text-[36px] font-bold mb-3">Alur Pendaftaran Magang</h1>
            <p class="text-gray-500 text-[14px] md:text-[16px]">Ikuti langkah-langkah berikut untuk mendaftar program magang di BPS Kota Pekanbaru</p>
        </div>

        {{-- Timeline Steps --}}
        <div class="relative">
            {{-- Horizontal line for desktop --}}
            <div class="hidden md:block absolute top-[60px] left-[10%] right-[10%] h-1 bg-gradient-to-r from-blue-400 via-blue-600 to-blue-800 rounded-full"></div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-8 md:gap-4">
                {{-- Step 1 --}}
                <div class="flex flex-col items-center text-center group delay-[100ms] duration-[600ms] taos:translate-y-[50px] taos:opacity-0" data-taos-offset="100">
                    <div class="w-[80px] h-[80px] md:w-[100px] md:h-[100px] rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white text-[28px] md:text-[36px] font-bold shadow-lg mb-4 transition-transform duration-300 group-hover:scale-110 z-10">
                        1
                    </div>
                    <div class="bg-white rounded-xl p-5 shadow-md w-full transition-all duration-300 group-hover:shadow-xl group-hover:-translate-y-2">
                        <i class="fa-solid fa-user-plus text-blue-600 text-[24px] mb-3"></i>
                        <h3 class="font-semibold text-[16px] text-gray-700 mb-2">Buat Akun</h3>
                        <p class="text-gray-500 text-[13px]">Daftar akun baru dengan email aktif dan lengkapi data diri</p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="flex flex-col items-center text-center group delay-[200ms] duration-[600ms] taos:translate-y-[50px] taos:opacity-0" data-taos-offset="100">
                    <div class="w-[80px] h-[80px] md:w-[100px] md:h-[100px] rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white text-[28px] md:text-[36px] font-bold shadow-lg mb-4 transition-transform duration-300 group-hover:scale-110 z-10">
                        2
                    </div>
                    <div class="bg-white rounded-xl p-5 shadow-md w-full transition-all duration-300 group-hover:shadow-xl group-hover:-translate-y-2">
                        <i class="fa-solid fa-edit text-blue-600 text-[24px] mb-3"></i>
                        <h3 class="font-semibold text-[16px] text-gray-700 mb-2">Isi Formulir</h3>
                        <p class="text-gray-500 text-[13px]">Lengkapi formulir pengajuan magang dengan data yang valid</p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="flex flex-col items-center text-center group delay-[300ms] duration-[600ms] taos:translate-y-[50px] taos:opacity-0" data-taos-offset="100">
                    <div class="w-[80px] h-[80px] md:w-[100px] md:h-[100px] rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white text-[28px] md:text-[36px] font-bold shadow-lg mb-4 transition-transform duration-300 group-hover:scale-110 z-10">
                        3
                    </div>
                    <div class="bg-white rounded-xl p-5 shadow-md w-full transition-all duration-300 group-hover:shadow-xl group-hover:-translate-y-2">
                        <i class="fa-solid fa-cloud-arrow-up text-blue-600 text-[24px] mb-3"></i>
                        <h3 class="font-semibold text-[16px] text-gray-700 mb-2">Upload Dokumen</h3>
                        <p class="text-gray-500 text-[13px]">Unggah surat pengantar, CV, dan dokumen pendukung lainnya</p>
                    </div>
                </div>

                {{-- Step 4 --}}
                <div class="flex flex-col items-center text-center group delay-[400ms] duration-[600ms] taos:translate-y-[50px] taos:opacity-0" data-taos-offset="100">
                    <div class="w-[80px] h-[80px] md:w-[100px] md:h-[100px] rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white text-[28px] md:text-[36px] font-bold shadow-lg mb-4 transition-transform duration-300 group-hover:scale-110 z-10">
                        4
                    </div>
                    <div class="bg-white rounded-xl p-5 shadow-md w-full transition-all duration-300 group-hover:shadow-xl group-hover:-translate-y-2">
                        <i class="fa-solid fa-hourglass-half text-blue-600 text-[24px] mb-3"></i>
                        <h3 class="font-semibold text-[16px] text-gray-700 mb-2">Proses Seleksi</h3>
                        <p class="text-gray-500 text-[13px]">Tunggu proses verifikasi dan seleksi dari tim BPS</p>
                    </div>
                </div>

                {{-- Step 5 --}}
                <div class="flex flex-col items-center text-center group delay-[500ms] duration-[600ms] taos:translate-y-[50px] taos:opacity-0" data-taos-offset="100">
                    <div class="w-[80px] h-[80px] md:w-[100px] md:h-[100px] rounded-full bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center text-white text-[28px] md:text-[36px] font-bold shadow-lg mb-4 transition-transform duration-300 group-hover:scale-110 z-10">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <div class="bg-white rounded-xl p-5 shadow-md w-full transition-all duration-300 group-hover:shadow-xl group-hover:-translate-y-2 border-2 border-green-500">
                        <i class="fa-solid fa-briefcase text-green-600 text-[24px] mb-3"></i>
                        <h3 class="font-semibold text-[16px] text-gray-700 mb-2">Mulai Magang</h3>
                        <p class="text-gray-500 text-[13px]">Selamat! Anda diterima dan siap memulai program magang</p>
                    </div>
                </div>
            </div>
        </div>

    </section>

    {{-- About section --}}
    <section class="w-full">
        <div class="m-0 p-0 w-full h-[75vh] absolute gradient-overlay-about z-0 parallax-about">
            {{-- <img src="{{ asset('assets/home/beranda/BPS.jpg') }}" alt="BPS image"
                class="object-cover w-full h-full"> --}}
        </div>
        <div class="relative px-[20px] md:px-[10%] h-[75vh] flex flex-col items-start text-start justify-center gap-8">
            <h1 class="font-bold text-white text-[33px] md:text-[36px] lg:text-[49px] leading-snug delay-[300ms] duration-[600ms] taos:translate-x-[-200px] taos:opacity-0"
                data-taos-offset="100">Belum kenal dengan BPS?</h1>
            <p class="font-light text-white text-[14px] w-[90%] lg:w-[60%] md:text-[18px] delay-[600ms] duration-[600ms] taos:translate-x-[-200px] taos:opacity-0"
                data-taos-offset="100">BPS atau Badan Pusat Statistik adalah Lembaga Pemerintah Non Kementerian yang
                bertanggung
                jawab langsung kepada Presiden. Sebelumnya, BPS merupakan Biro Pusat Statistik, yang dibentuk
                berdasarkan UU Nomor 6 Tahun 1960 tentang Sensus dan UU Nomer 7 Tahun 1960 tentang Statistik.</p>
            <div
                class="flex flex-col md:flex-row gap-5 items-center text-center w-full md:w-fit delay-[1000ms] duration-[600ms] taos:scale-[1.1] taos:opacity-0">
                <a href="https://ppid.bps.go.id/app/konten/0000/Profil-BPS.html" target="_blank"
                    class="rounded-[10px] w-full md:px-9 py-3 bg-blue-600 text-white text-[14px] whitespace-nowrap transition duration-300 ease-in-out hover:bg-blue-500 flex items-center justify-center gap-3">
                    Lebih Lengkap
                    <i class="transition-transform duration-300 fa-solid fa-arrow-right text-white"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- Footer setion --}}
    <footer
        class="flex flex-col w-full h-fit gap-7 px-5 py-5 md:px-[10%] md:py-7 bg-gradient-to-r from-blue-900 to-blue-500">
        <div class="flex gap-3">
            <div class="flex items-center justify-start md:justify-center border-r border-white border-transparent">
                <img class="w-[100%] mr-1" src="{{ asset('assets/bps-logo.svg') }}" alt="BPS logo image">
            </div>
            <div class="text-white md:block">
                <h1 class="font-normal text-[18px] md:text-[25px]">Badan Pusat Statistik</h1>
                <p class="font-light text-[15px] md:text-[20px]">Kota Pekanbaru</p>
            </div>
        </div>
        <div class="flex flex-col md:flex-row justify-between gap-5">
            <div class="flex items-end text-white">
                <p class="lg:w-[50%] font-light">
                    Badan Pusat Statistik Kota Pekanbaru (BPS-Statistics of Pekanbaru Municipality)Jl. Rawa Indah
                    Pekanbaru 28125 Riau Indonesia
                    <br>
                    Telp (62-761) 787456
                    <br>
                    Faks (62-761) 7872789
                    <br>
                    email: bps1471@bps.go.id
                </p>
            </div>
            <div class="w-[50%] h-fit bg-white rounded-lg">
                <img src="{{ asset('assets/cover.webp') }}" alt="Berakhlak logo image">
            </div>
        </div>
        <span class="w-full border-b border-white"></span>
        <div class="flex flex-col-reverse md:flex-row gap-3 items-center justify-between">
            <div class="text-white font-light">
                <h1>Hak Cipta © {{ date('Y') }} Badan Pusat Statistik</h1>
            </div>
            <div class="flex gap-5 text-white">
                <a href="https://www.instagram.com/bpskotapekanbaru/" target="_blank"><i
                        class="fa-brands fa-instagram"></i></a>
                <a href="https://www.youtube.com/channel/UCbWrkaa-x6cFElnGn-T7aPg/featured" target="_blank"><i
                        class="fa-brands fa-youtube"></i></a>
                <a href="https://www.facebook.com/profile.php?id=100072273431504" target="_blank"><i
                        class="fa-brands fa-facebook-f"></i></a>
                <a href="https://x.com/bps_statistics" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/taos@1.0.5/dist/taos.js"></script>
</body>

</html>