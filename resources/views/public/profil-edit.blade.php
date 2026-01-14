@extends('layouts.app')

@section('title', 'User Profil Edit')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-4 lg:gap-x-6 gap-x-0 gap-y-6">

        <div class="col-span-4 card rounded-lg bg-white p-5 h-fit dark:bg-[#14181b] transition-all duration-200">
            <a href="/profil" class="pjax-link text-gray-900 text-xl flex gap-1 items-center font-semibold dark:text-white">
                <i class="ti ti-chevron-left"></i>
                <p>Update Data Profil</p>
            </a>
        </div>

        <div class="lg:grid grid-cols-1 lg:grid-cols-6 gap-x-6 gap-y-6 col-span-4">
            <div class="col-span-1">
                <ul class="flex-column space-y space-y-4 text-sm font-medium text-gray-500 dark:text-gray-400 mb-4 md:mb-0" id="default-styled-tab" data-tabs-toggle="#default-styled-tab-content" data-tabs-active-classes="text-white bg-blue-600" data-tabs-inactive-classes="bg-white card hover:text-blue-600" role="tablist">
                    <li role="presentation">
                        <button class="inline-flex items-center px-4 py-2 text-white rounded-md active w-full transition-all duration-200 font-normal gap-3 tab-button" aria-current="page" id="biodata-styled-tab" data-selected="biodata" data-tabs-target="#styled-biodata" type="button" role="tab" aria-controls="biodata" aria-selected="false">
                            <i class="ti ti-user-scan text-lg"></i>
                            <p>Biodata</p>
                        </button>
                    </li>
                    <li role="presentation">
                        <button class="inline-flex items-center px-4 py-2 text-white rounded-md active w-full transition-all duration-200 font-normal gap-3 tab-button" id="akademik-styled-tab" data-selected="akademik" data-tabs-target="#styled-akademik" type="button" role="tab" aria-controls="akademik" aria-selected="false">
                            <i class="ti ti-school text-lg"></i>
                            <p>Akademik</p>
                        </button>
                    </li>
                    <li role="presentation">
                        <button class="inline-flex items-center px-4 py-2 text-white rounded-md active w-full transition-all duration-200 font-normal gap-3 tab-button" id="dokumen-styled-tab" data-selected="dokumen" data-tabs-target="#styled-dokumen" type="button" role="tab" aria-controls="dokumen" aria-selected="false">
                            <i class="ti ti-file-description text-lg"></i>
                            <p>Dokumen</p>
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card rounded-lg p-5 col-span-5 bg-white h-fit" id="default-styled-tab-content">
                <div class="bg-white text-medium text-gray-500 rounded-lg w-full" id="styled-biodata" role="tabpanel" aria-labelledby="profile-tab">
                    <h4 class="text-gray-800 text-2xl pb-3 border-b border-gray-300 font-semibold dark:text-white">
                        Biodata
                    </h4>
                    <div class="md:px-[0%] md:pt-[2%]">
                        @livewire('edit-biodata')
                    </div>
                </div>
                <div class="bg-white text-medium text-gray-500 rounded-lg w-full" id="styled-akademik" role="tabpanel" aria-labelledby="dashboard-tab">
                    <h4 class="text-gray-800 text-2xl pb-3 border-b border-gray-300 font-semibold dark:text-white">
                        Akademik
                    </h4>
                    <div class="md:px-[0%] md:pt-[2%]">
                        @livewire('edit-akademik')
                    </div>
                </div>
                <div class="bg-white text-medium text-gray-500 rounded-lg w-full" id="styled-dokumen" role="tabpanel" aria-labelledby="settings-tab">
                    <h4 class="text-gray-800 text-2xl pb-3 border-b border-gray-300 font-semibold dark:text-white">
                        Dokumen
                    </h4>
                    <div class="md:px-[0%] md:pt-[2%]">
                        @livewire('edit-dokumen')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil query string dari URL
            const params = new URLSearchParams(window.location.search);
            const selectedTab = params.get('selected');
        
            if (selectedTab) {
                let tabId;
        
                // Tentukan tab ID berdasarkan nilai data-selected
                switch (selectedTab) {
                    case 'biodata':
                        tabId = 'biodata-styled-tab';
                        break;
                    case 'akademik':
                        tabId = 'akademik-styled-tab';
                        break;
                    case 'dokumen':
                        tabId = 'dokumen-styled-tab';
                        break;
                    default:
                        tabId = null;
                }
        
                // Jika tabId valid, set aria-selected menjadi true
                if (tabId) {
                    document.getElementById(tabId).setAttribute('aria-selected', 'true');
                }
            }
        
            // Tambahkan event listener untuk mengubah query string saat tombol ditekan
            document.querySelectorAll('.tab-button').forEach(button => {
                button.addEventListener('click', function() {
                    const selected = this.getAttribute('data-selected');
                    const url = new URL(window.location);
                    url.searchParams.set('selected', selected);
                    window.history.pushState({}, '', url);
                });
            });
        });
    </script>
@endsection
