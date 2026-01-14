@extends('layouts.app')

@section('title', 'User Profil')

@section('content')

    @php
        $firstLetter = strtoupper(substr(Auth::user()->name, 0, 1));
        use Carbon\Carbon;
    @endphp

    <div class="w-full h-24 md:h-44 rounded-lg bg-blue-500 relative overflow-hidden">
        <img class="absolute inset-0 w-full h-full object-cover rotate-180"
            src="{{ asset('assets/images/usernormal/bg-dash.svg') }}" alt="">
    </div>

    <div
        class="card flex items-center justify-between -mt-11 mx-7 rounded-lg bg-white bg-opacity-30 backdrop-filter backdrop-blur-xl p-4 h-full dark:bg-[#14181b] transition-all duration-200">
        <div class="flex items-center gap-4">
            @if (!empty(Auth::user()->foto_profil))
                <img id="profile-image" src="{{ Storage::url(Auth::user()->foto_profil) }}" alt="Preview Foto Profil"
                    class="w-14 h-14 object-cover rounded-lg outline outline-blue-600 cursor-pointer"
                    onclick="openPreview('{{ Storage::url(Auth::user()->foto_profil) }}')">
            @else
                <h1 class="flex w-14 h-14 items-center justify-center text-xl text-white bg-blue-600 rounded-lg">
                    {{ $firstLetter }}
                </h1>
            @endif
            <div>
                <p class="text-lg text-gray-800 font-medium">
                    {{ Auth::user()->name }}</p>
                <p class="text-[12px] text-gray-600">Siswa/Mahasiswa</p>
            </div>
        </div>
        {{-- <div class="card w-fit h-fit flex items-start lg:items-center px-3 py-2 bg-red-100 rounded-lg border text-red-700 border-red-700">
            <p class="text-sm">Belum terdaftar magang</p>
        </div> --}}
    </div>

    <div class="grid grid-cols-1 mt-6 lg:grid-cols-5 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
        <div class="col-span-3 card rounded-lg bg-white p-5 h-fit dark:bg-[#14181b] transition-all duration-200">
            <div class="flex justify-between text-gray-900">
                <h1 class="font-semibold text-2xl">Data Pribadi</h1>
                <a href="/profil-edit?selected=biodata" class="pjax-link" data-selected="biodata" id="edit-biodata">
                    <i class="ti ti-pencil text-xl"></i>
                </a>
            </div>
            <p class="font-normal text-sm text-gray-600">Pastikan data pribadi kamu benar</p>
            <span class="border-b border-gray-300 block my-4"></span>
            <div class="mt-4">
                <h6 class="text-[17px] font-semibold text-gray-800">Tentang Saya</h6>
                @if (!empty(Auth::user()->tentang_saya))
                    <p class="text-gray-600 text-sm">
                        {{ Auth::user()->tentang_saya }}
                    </p>
                @else
                    <div class="flex gap-1 items-center text-red-600">
                        <i class="ti ti-exclamation-circle text-sm"></i>
                        <p class="text-sm">data belum diisi</p>
                    </div>
                @endif
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Nama</h6>
                @if (!empty(Auth::user()->name))
                    <p class="text-gray-600 text-sm">
                        {{ Auth::user()->name }}
                    </p>
                @else
                    <div class="flex gap-1 items-center text-red-600">
                        <i class="ti ti-exclamation-circle text-sm"></i>
                        <p class="text-sm">data belum diisi</p>
                    </div>
                @endif
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Jenis Kelamin</h6>
                @if (!empty(Auth::user()->jenis_kelamin))
                    <p class="text-gray-600 text-sm">
                        {{ Auth::user()->jenis_kelamin }}
                    </p>
                @else
                    <div class="flex gap-1 items-center text-red-600">
                        <i class="ti ti-exclamation-circle text-sm"></i>
                        <p class="text-sm">data belum diisi</p>
                    </div>
                @endif
                <div class="flex gap-5">
                    <div>
                        <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Tempat Lahir</h6>
                        @if (!empty(Auth::user()->tempat_lahir))
                            <p class="text-gray-600 text-sm">
                                {{ Auth::user()->tempat_lahir }}
                            </p>
                        @else
                            <div class="flex gap-1 items-center text-red-600">
                                <i class="ti ti-exclamation-circle text-sm"></i>
                                <p class="text-sm">data belum diisi</p>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Tanggal Lahir</h6>
                        @if (!empty(Auth::user()->tanggal_lahir))
                            <p class="text-gray-600 text-sm">
                                {{ Carbon::parse(Auth::user()->tanggal_lahir)->format('j-F-Y') }}
                            </p>
                        @else
                            <div class="flex gap-1 items-center text-red-600">
                                <i class="ti ti-exclamation-circle text-sm"></i>
                                <p class="text-sm">data belum diisi</p>
                            </div>
                        @endif
                    </div>
                </div>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">No Handphone</h6>
                @if (!empty(Auth::user()->nomor_hp))
                    <p class="text-gray-600 text-sm">
                        {{ Auth::user()->nomor_hp }}
                    </p>
                @else
                    <div class="flex gap-1 items-center text-red-600">
                        <i class="ti ti-exclamation-circle text-sm"></i>
                        <p class="text-sm">data belum diisi</p>
                    </div>
                @endif
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Email</h6>
                @if (!empty(Auth::user()->email))
                    <p class="text-gray-600 text-sm">
                        {{ Auth::user()->email }}
                    </p>
                @else
                    <div class="flex gap-1 items-center text-red-600">
                        <i class="ti ti-exclamation-circle text-sm"></i>
                        <p class="text-sm">data belum diisi</p>
                    </div>
                @endif
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Alamat Lengkap</h6>
                @if (!empty(Auth::user()->alamat))
                    <p class="text-gray-600 text-sm">
                        {{ Auth::user()->alamat }}
                    </p>
                @else
                    <div class="flex gap-1 items-center text-red-600">
                        <i class="ti ti-exclamation-circle text-sm"></i>
                        <p class="text-sm">data belum diisi</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex flex-col gap-6 col-span-2">
            <div class="card rounded-lg bg-white p-5 h-fit dark:bg-[#14181b] transition-all duration-200">
                <div class="flex justify-between text-gray-900">
                    <h1 class="font-semibold text-2xl">Informasi Akademik</h1>
                    <a href="/profil-edit?selected=akademik" class="pjax-link" data-selected="akademik" id="edit-akademik">
                        <i class="ti ti-pencil text-xl"></i>
                    </a>
                </div>
                <p class="font-normal text-sm text-gray-600">Pastikan data akademik kamu benar</p>
                <span class="border-b border-gray-300 block my-4"></span>
                <div class="mt-4">
                    <h6 class="text-[17px] font-semibold text-gray-800">Asal Instansi</h6>
                    @if (!empty(Auth::user()->institusi))
                        <p class="text-gray-600 text-sm">
                            {{ Auth::user()->institusi }}
                        </p>
                    @else
                        <div class="flex gap-1 items-center text-red-600">
                            <i class="ti ti-exclamation-circle text-sm"></i>
                            <p class="text-sm">data belum diisi</p>
                        </div>
                    @endif
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Jurusan</h6>
                    @if (!empty(Auth::user()->jurusan))
                        <p class="text-gray-600 text-sm">
                            {{ Auth::user()->jurusan }}
                        </p>
                    @else
                        <div class="flex gap-1 items-center text-red-600">
                            <i class="ti ti-exclamation-circle text-sm"></i>
                            <p class="text-sm">data belum diisi</p>
                        </div>
                    @endif
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Nomor Induk Siswa/Mahasiswa</h6>
                    @if (!empty(Auth::user()->nomor_induk))
                        <p class="text-gray-600 text-sm">
                            {{ Auth::user()->nomor_induk }}
                        </p>
                    @else
                        <div class="flex gap-1 items-center text-red-600">
                            <i class="ti ti-exclamation-circle text-sm"></i>
                            <p class="text-sm">data belum diisi</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card rounded-lg bg-white p-5 h-fit dark:bg-[#14181b] transition-all duration-200">
                <div class="flex justify-between text-gray-900">
                    <h1 class="font-semibold text-2xl">Dokumen</h1>
                    <a href="/profil-edit?selected=dokumen" class="pjax-link" data-selected="dokumen" id="edit-dokumen">
                        <i class="ti ti-pencil text-xl"></i>
                    </a>
                </div>
                <p class="font-normal text-sm text-gray-600">Lengkapi dokumen kamu</p>
                <span class="border-b border-gray-300 block my-4"></span>
                <div class="mt-4">
                    <h6 class="text-[17px] font-semibold text-gray-800">Kartu Tanda Penduduk</h6>
                    @if (!empty(Auth::user()->kartu_penduduk))
                        <div
                            class="flex flex-col md:flex-row items-center px-2 py-2 mt-2 justify-between text-red-600 border-2 border-dashed border-gray-300 bg-gray-100 rounded-lg">
                            <div class="flex items-center gap-2">
                                <i class="ti ti-file-text text-2xl text-gray-700"></i>
                                <p class="text-gray-600 text-sm">{{ Auth::user()->original_filename_ktp }}</p>
                            </div>
                            <button
                                class="px-3 py-1 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap"
                                onclick="openPreview('{{ Storage::url(Auth::user()->kartu_penduduk) }}')">
                                Lihat file
                            </button>
                        </div>
                    @else
                        <div
                            class="flex items-center px-2 py-2 mt-2 justify-between text-red-600 border-2 border-dashed border-gray-300 bg-gray-100 rounded-lg">
                            <div class="flex items-center gap-2">
                                <i class="ti ti-file-text text-2xl text-gray-700"></i>
                                <p class="text-sm">dokumen belum di upload</p>
                            </div>
                        </div>
                    @endif
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Kartu Tanda Siswa/Mahasiswa</h6>
                    @if (!empty(Auth::user()->kartu_tanda))
                        <div
                            class="flex flex-col md:flex-row items-center px-2 py-2 mt-2 justify-between text-red-600 border-2 border-dashed border-gray-300 bg-gray-100 rounded-lg">
                            <div class="flex items-center gap-2">
                                <i class="ti ti-file-text text-2xl text-gray-700"></i>
                                <p class="text-gray-600 text-sm">{{ Auth::user()->original_filename_kartu }}</p>
                            </div>
                            <button
                                class="px-3 py-1 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap"
                                onclick="openPreview('{{ Storage::url(Auth::user()->kartu_tanda) }}')">
                                Lihat file
                            </button>
                        </div>
                    @else
                        <div
                            class="flex items-center px-2 py-2 mt-2 justify-between text-red-600 border-2 border-dashed border-gray-300 bg-gray-100 rounded-lg">
                            <div class="flex items-center gap-2">
                                <i class="ti ti-file-text text-2xl text-gray-700"></i>
                                <p class="text-sm">dokumen belum di upload</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        function openPreview(url) {
            const screenWidth = window.screen.width;
            const screenHeight = window.screen.height;
            const width = screenWidth / 2;
            const height = screenHeight / 2;
            const left = (screenWidth - width) / 2;
            const top = (screenHeight - height) / 2;

            const newWindow = window.open(
                '',
                '',
                `width=${width},height=${height},top=${top},left=${left}`
            );

            if (newWindow) {
                newWindow.document.write('<img src="' + url + '" style="width:100%;height:auto;">');
                newWindow.document.title = "Image Preview";
            } else {
                alert('Preview dokumen tidak tersedia di tampilan mobile');
            }
        }
    </script>
@endsection
