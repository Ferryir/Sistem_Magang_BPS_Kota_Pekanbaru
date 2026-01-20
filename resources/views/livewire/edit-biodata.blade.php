@php
    $firstLetter = strtoupper(substr(Auth::user()->name, 0, 1));
@endphp

<form class="flex flex-col gap-5" wire:submit="update_data">
    <div class="">
        <label for="" class="block mb-1 text-md font-medium text-gray-700">Foto Profil</label>
        @if ($foto_profil)
            @if (is_string($foto_profil))
                <div class="relative w-28 h-28 mt-3 rounded-full overflow-hidden cursor-pointer bg-gray-200 border-2 group"
                    onclick="document.getElementById('profile-input').click()">
                    <div
                        class="absolute inset-0 flex justify-center items-center bg-black bg-opacity-0 transition duration-300 ease-in-out group-hover:bg-opacity-70 z-10">
                        <i class="ti ti-photo text-white text-2xl group-hover:block hidden"></i>
                    </div>
                    <img id="profile-image" src="{{ Storage::url($foto_profil) }}" alt="Preview Foto Profil"
                        class="absolute inset-0 w-full h-full object-cover">
                    <input type="file" name="foto_profil" id="profile-input" class="hidden" accept=".png, .jpg, .jpeg"
                        wire:model="foto_profil" />
                </div>
            @else
                <div class="relative w-28 h-28 mt-3 rounded-full overflow-hidden cursor-pointer bg-gray-200 border-2 group"
                    onclick="document.getElementById('profile-input').click()">
                    <div
                        class="absolute inset-0 flex justify-center items-center bg-black bg-opacity-0 transition duration-300 ease-in-out group-hover:bg-opacity-70 z-10">
                        <i class="ti ti-photo text-white text-2xl group-hover:block hidden"></i>
                    </div>
                    <img id="profile-image" src="{{ $foto_profil->temporaryUrl() }}" alt="Preview Foto Profil"
                        class="absolute inset-0 w-full h-full object-cover">
                    <input type="file" name="foto_profil" id="profile-input" class="hidden" accept=".png, .jpg, .jpeg"
                        wire:model="foto_profil" />
                </div>
            @endif
        @else
            <div class="relative w-28 h-28 mt-3 rounded-full overflow-hidden cursor-pointer bg-blue-600 border-2 group"
                onclick="document.getElementById('profile-input').click()">
                <div
                    class="absolute inset-0 flex justify-center items-center bg-black bg-opacity-0 transition duration-300 ease-in-out group-hover:bg-opacity-70 z-10">
                    <i class="ti ti-photo text-white text-2xl group-hover:block hidden"></i>
                </div>
                <span id="initial-letter"
                    class="absolute inset-0 flex justify-center items-center text-white text-3xl group-hover:hidden">{{ $firstLetter }}</span>
                <img id="profile-image" class="absolute inset-0 w-full h-full object-cover hidden" />
                <input type="file" name="foto_profil" id="profile-input" class="hidden" accept=".png, .jpg, .jpeg"
                    wire:model="foto_profil" />
            </div>
        @endif
        <p class="text-sm mt-4">Upload foto 1:1 (square)</p>
        @error('foto_profil')
            <span class="text-red-500 text-[11px]">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="tentang_saya" class="block mb-1 text-md font-medium text-gray-700">Tentang Saya<span
                class="text-red-500 ml-1">*</span></label>
        <textarea maxlength="250" name="tentang_saya" id="tentang_saya" wire:model.live="tentang_saya"
            class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]"
            placeholder="Masukkan deskripsi diri kamu"></textarea>
        @error('tentang_saya')
            <span class="text-red-500 text-[11px]">{{ $message }}</span>
        @enderror
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label for="name" class="block mb-1 text-md font-medium text-gray-700">Nama<span
                    class="text-red-500 ml-1">*</span></label>
            <input type="text" name="name" id="nama" wire:model.live="name"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]"
                placeholder="Masukkan nama lengkap" />
            @error('name')
                <span class="text-red-500 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="jenis_kelamin" class="block mb-1 text-md font-medium text-gray-700">Jenis Kelamin<span
                    class="text-red-500 ml-1">*</span></label>
            <select name="jenis_kelamin" id="jenis_kelamin" wire:model.live="jenis_kelamin"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5">
                <option value="" disabled selected hidden>Pilih jenis kelamin</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
            @error('jenis_kelamin')
                <span class="text-red-500 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="tempat_lahir" class="block mb-1 text-md font-medium text-gray-700">Tempat Lahir<span
                    class="text-red-500 ml-1">*</span></label>
            <input type="text" name="tempat_lahir" id="tempat_lahir" wire:model.live="tempat_lahir"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]"
                placeholder="Masukkan tempat lahir" />
            @error('tempat_lahir')
                <span class="text-red-500 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="tanggal_lahir" class="block mb-1 text-md font-medium text-gray-700">Tanggal Lahir<span
                    class="text-red-500 ml-1">*</span></label>
            <div wire:ignore>
                <input type="text" name="tanggal_lahir" id="tanggal_lahir" wire:model.live="tanggal_lahir"
                    class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]"
                    placeholder="Pilih tanggal lahir" />
            </div>
            @error('tanggal_lahir')
                <span class="text-red-500 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        @push('styles')
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
            <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">
            <style>
                .flatpickr-calendar {
                    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                    border-radius: 0.5rem;
                }
            </style>
        @endpush

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
            <script>
                function initDatePicker() {
                    flatpickr("#tanggal_lahir", {
                        locale: "id",
                        altInput: true,
                        altFormat: "j F Y",
                        dateFormat: "Y-m-d",
                        maxDate: "today",
                        disableMobile: false,
                        monthSelectorType: 'static',
                        yearSelectorType: 'static',
                        onChange: function (selectedDates, dateStr, instance) {
                            instance.element.value = dateStr;
                            instance.element.dispatchEvent(new Event('input'));
                        }
                    });
                }

                // Initialize on load
                initDatePicker();

                // Re-initialize after Pjax
                $(document).on('pjax:complete', function () {
                    initDatePicker();
                });

                // Handle Livewire updates if necessary (though wire:ignore helps)
                document.addEventListener('livewire:initialized', () => {
                    initDatePicker();
                });
            </script>
        @endpush

        <div>
            <label for="nomor_hp" class="block mb-1 text-md font-medium text-gray-700">Nomor HP<span
                    class="text-red-500 ml-1">*</span></label>
            <input type="number" min="0" name="nomor_hp" id="nomor_hp" wire:model.live="nomor_hp"
                placeholder="Masukkan nomor HP"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
            @error('nomor_hp')
                <span class="text-red-500 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="alamat" class="block mb-1 text-md font-medium text-gray-700">Alamat Lengkap<span
                    class="text-red-500 ml-1">*</span></label>
            <input maxlength="250" type="text" name="alamat" id="alamat" wire:model.live="alamat"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]"
                placeholder="Masukkan alamat lengkap" />
            @error('alamat')
                <span class="text-red-500 text-[11px]">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <button id="submitBtn" type="submit"
        class="w-full text-white bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:cursor-not-allowed disabled:bg-blue-400">Perbarui
        Biodata</button>
</form>

<script>
    document.getElementById('profile-input').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imgElement = document.getElementById('profile-image');
                imgElement.src = e.target.result;
                imgElement.classList.remove('hidden');

                const initialLetterElement = document.getElementById('initial-letter');
                initialLetterElement.classList.add('hidden');

                // Remove the blue background
                const parentDiv = imgElement.closest('div');
                parentDiv.classList.remove('bg-blue-600');
            }
            reader.readAsDataURL(file);
        }
    });
</script>