@extends('layouts.app')

@section('title', 'Pengajuan Saya')

@section('content')
    @php
        $firstLetter = strtoupper(substr($pengajuan->name, 0, 1));
        use Carbon\Carbon;
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-4 lg:gap-x-6 gap-x-0 lg:gap-y-6 gap-y-6">

        <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <a href="/pengajuan" class="pjax-link w-fit flex items-center gap-1">
                <i class="ti ti-chevron-left text-xl"></i>
                <h4 class="text-gray-900 font-semibold text-xl dark:text-white">
                    Pengajuan Saya
                </h4>
            </a>
        </div>

        @if ($pengajuan->status_pengajuan == 'accept-first')
            @if ($pengajuan->surat_pengantar == null)
                <div class="col-span-4 grid grid-cols-1 lg:grid-cols-4 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                    <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                        <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-blue-100 rounded-lg border text-blue-700 border-blue-700">
                            <i class="ti ti-alert-circle text-lg"></i>
                            <p class="text-sm">Segera kirim surat pengantar dari sekolah atau universitas, tenggat <span class="font-bold">{{ \Carbon\Carbon::parse($pengajuan->tenggat)->translatedFormat('j F Y') }}</span></p>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-span-4 grid grid-cols-1 lg:grid-cols-4 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                    <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                        <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-blue-100 rounded-lg border text-blue-700 border-blue-700">
                            <i class="ti ti-alert-circle text-lg"></i>
                            <p class="text-sm">Surat pengantar sedang dalam proses pengecekan</p>
                        </div>
                    </div>
                </div>
            @endif
        @elseif ($pengajuan->status_pengajuan == 'reject-time')
            <div class="col-span-4 grid grid-cols-1 lg:grid-cols-4 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                    <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-red-100 rounded-lg border text-red-700 border-red-700">
                        <i class="ti ti-alert-triangle text-lg"></i>
                        <p class="text-sm">Kamu melewati tenggat upload surat pengantar!, <span class="font-semibold underline"><a href="/dashboard" class="pjax-link">ajukan ulang</a></span></p>
                    </div>
                </div>
            </div>
        @elseif ($pengajuan->komentar != null)
            <div class="col-span-4 grid grid-cols-1 lg:grid-cols-4 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                    <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-red-100 rounded-lg border text-red-700 border-red-700">
                        <p class="text-sm"><span class="font-semibold">Pesan penolakan: </span>{{ $pengajuan->komentar }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-span-4 grid grid-cols-1 lg:grid-cols-4 lg:gap-x-6 gap-x-0 lg:gap-y-6 gap-y-6">

            <div class="col-span-2 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="">
                    <h4 class="text-gray-800 text-[22px] pb-3 border-b border-gray-300 font-semibold dark:text-white">
                        Pengajuan Program
                    </h4>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Jenis Magang</h6>
                    <p class="text-gray-600 text-sm">
                        {{ $pengajuan->jenis_magang }}
                    </p>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Bidang Tujuan</h6>
                    <p class="text-gray-600 text-sm">
                        {{ $pengajuan->bidang_tujuan }}
                    </p>
                    <div class="flex gap-5">
                        <div>
                            <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Tanggal Mulai</h6>
                            <p class="text-gray-600 text-sm">
                                {{ Carbon::parse($pengajuan->tanggal_mulai)->format('j-F-Y') }}
                            </p>
                        </div>
                        <div>
                            <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Tanggal selesai</h6>
                            <p class="text-gray-600 text-sm">
                                {{ Carbon::parse($pengajuan->tanggal_selesai)->format('j-F-Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-2 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="">
                    <h4 class="text-gray-800 text-[22px] pb-3 border-b border-gray-300 font-semibold dark:text-white">
                        Informasi Akademik
                    </h4>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Asal Instansi</h6>
                    <p class="text-gray-600 text-sm">
                        {{ $pengajuan->institusi }}
                    </p>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Jurusan</h6>
                    <p class="text-gray-600 text-sm">
                        {{ $pengajuan->jurusan }}
                    </p>
                    <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Nomor Induk Siswa/Mahasiswa</h6>
                    <p class="text-gray-600 text-sm">
                        {{ $pengajuan->nomor_induk }}
                    </p>
                </div>
            </div>

        </div>

        <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <div class="">
                <h4 class="text-gray-800 text-[22px] pb-3 border-b border-gray-300 font-semibold dark:text-white">
                    Biodata
                </h4>
                <div class="mt-4">
                    @if (!empty($pengajuan->foto_profil))
                        <img id="profile-image" src="{{ Storage::url($pengajuan->foto_profil) }}"
                            alt="Preview Foto Profil"
                            class="w-28 h-28 object-cover rounded-full outline outline-blue-600 cursor-pointer"
                            onclick="openPreview('{{ Storage::url($pengajuan->foto_profil) }}')">
                    @else
                        <h1 class="flex w-28 h-28 items-center justify-center text-3xl text-white bg-blue-600 rounded-full">
                            {{ $firstLetter }}
                        </h1>
                    @endif
                </div>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Tentang Saya</h6>
                <p class="text-gray-600 text-sm">
                    {{ $pengajuan->tentang_saya }}
                </p>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Nama</h6>
                <p class="text-gray-600 text-sm">
                    {{ $pengajuan->name }}
                </p>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Jenis Kelamin</h6>
                <p class="text-gray-600 text-sm">
                    {{ $pengajuan->jenis_kelamin }}
                </p>
                <div class="flex gap-5">
                    <div>
                        <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Tempat Lahir</h6>
                        <p class="text-gray-600 text-sm">
                            {{ $pengajuan->tempat_lahir }}
                        </p>
                    </div>
                    <div>
                        <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Tanggal Lahir</h6>
                        <p class="text-gray-600 text-sm">
                            {{ Carbon::parse($pengajuan->tanggal_lahir)->format('j-F-Y') }}
                        </p>
                    </div>
                </div>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">No Handphone</h6>
                <p class="text-gray-600 text-sm">
                    {{ $pengajuan->nomor_hp }}
                </p>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Email</h6>
                <p class="text-gray-600 text-sm">
                    {{ $pengajuan->email }}
                </p>
                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Alamat Lengkap</h6>
                <p class="text-gray-600 text-sm">
                    {{ $pengajuan->alamat }}
                </p>
            </div>
        </div>

        <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <h4 class="text-gray-800 text-[22px] pb-3 border-b border-gray-300 font-semibold dark:text-white">
                Dokumen
            </h4>
            <div class="mt-4">
                <h6 class="text-[17px] font-semibold text-gray-800">Kartu Tanda Penduduk</h6>
                <div
                    class="flex flex-col md:flex-row items-center px-2 py-2 mt-2 justify-between text-red-600 border-2 border-dashed border-gray-300 bg-gray-100 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-file-text text-2xl text-gray-700"></i>
                        <p class="text-gray-600 text-sm">{{ $pengajuan->original_filename_ktp }}</p>
                    </div>
                    <button
                        class="px-3 py-1 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap"
                        onclick="openPreview('{{ Storage::url($pengajuan->kartu_penduduk) }}')">
                        Lihat file
                    </button>
                </div>

                <h6 class="text-[17px] mt-4 font-semibold text-gray-800">Kartu Tanda Siswa/Mahasiswa</h6>
                <div
                    class="flex flex-col md:flex-row items-center px-2 py-2 mt-2 justify-between text-red-600 border-2 border-dashed border-gray-300 bg-gray-100 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-file-text text-2xl text-gray-700"></i>
                        <p class="text-gray-600 text-sm">{{ $pengajuan->original_filename_kartu }}</p>
                    </div>
                    <button
                        class="px-3 py-1 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap"
                        onclick="openPreview('{{ Storage::url($pengajuan->kartu_tanda) }}')">
                        Lihat file
                    </button>
                </div>
            </div>
        </div>

        @if ($pengajuan->status_pengajuan == 'waiting')
        <div
            class="col-span-4 card flex flex-col gap-5 rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <button
                class="btn-delete-pengajuan w-full p-2 flex items-center justify-center gap-2 font-medium bg-red-600 border-2 border-transparent text-white rounded-lg whitespace-nowrap hover:bg-white hover:text-red-600 hover:border-red-600 transition-all duration-200">
                <i class="ti ti-trash text-sm"></i>
                <p class="text-sm">Hapus Pengajuan</p>
            </button>

            <div class="act-delete-pengajuan hidden ">
                <div class="justify-center items-center w-full max-h-full">
                    <div class="relative p-4 w-full max-h-full">
                        <div class="relative">
                            <button
                                class="close-modal absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-4 md:p-5 text-center">
                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <h3 class="mb-5 text-[15px] font-normal text-gray-500 dark:text-gray-400">Apakah kamu yakin
                                    ingin menghapus pengajuan ini?</h3>
                                <form action="{{ route('usernormal.delete-pengajuan', $pengajuan->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center cursor-pointer">
                                        Ya, Hapus
                                    </button>
                                </form>
                                <button
                                    class="close-modal py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    Tidak
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif


    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteBtn = document.querySelector('.btn-delete-pengajuan');
            const deleteDiv = document.querySelector('.act-delete-pengajuan');
            const closeMdls = document.querySelectorAll('.close-modal');

            deleteBtn.addEventListener('click', function() {
                deleteDiv.classList.remove('hidden');
                deleteDiv.classList.add('fade-in-div', 'show-div');
                deleteDiv.scrollIntoView({
                    behavior: 'smooth'
                });
            });

            closeMdls.forEach(closeMdl => {
                closeMdl.addEventListener('click', function() {
                    deleteDiv.classList.remove('show-div');
                    deleteDiv.classList.add('hidden');
                    deleteDiv.scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        });

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
