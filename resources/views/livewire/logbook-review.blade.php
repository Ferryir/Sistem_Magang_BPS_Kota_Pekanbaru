<div>
    <div class="col-span-4 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
        <div class="">
            <h4 class="text-gray-900 font-semibold text-[20px] dark:text-white">
                Logbook Hari ke-1
            </h4>
            <h2 class="text-gray-900 text-sm dark:text-white">
                27 September 202
            </h2>
            <div
                class="w-full h-fit flex gap-3 items-start mt-4 lg:items-center p-3 bg-amber-100 rounded-lg border text-amber-700 border-amber-700">
                <i class="ti ti-alert-circle text-lg"></i>
                <p class="text-sm">Silahkan isi kegiatan harian anda pada kolom dibawah ini</p>
            </div>
        </div>
    </div>
    <div class="col-span-4 card mt-6 rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
        <div>
            <label class="block mb-2 text-[17px] font-semibold">
                Kegiatan<span class="text-red-500 ml-1">*</span></label>
            <textarea wire:model="kegiatan"
                class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                rows="6" placeholder="Masukkan kegiatan" required>Hari ini saya melanjutkan project yang sudah dikerjakan sebelumnya dan membuat desain website baru</textarea>
        </div>
        <div>
            <div class="mt-5">
                <h6 class="text-[17px] font-semibold text-gray-800">Lampiran<span class="text-red-500 ml-1">*</span>
                </h6>
                <div
                    class="flex flex-col md:flex-row items-center px-2 py-3 mt-2 justify-between text-red-600 border-2 border-dashed border-gray-300 bg-gray-100 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-file-text text-2xl text-gray-700"></i>
                        <p class="text-gray-600 text-sm" id="file-name">xxxxxxxxxxxxx</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <label for="file-upload" class="cursor-pointer">
                            <div
                                class="px-3 py-2 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap">
                                Lihat File
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <label class="block mb-2 text-[17px] font-semibold">
                Komentar<span class="text-red-500 ml-1">*</span></label>
            <textarea wire:model="komentar"
                class="w-full p-3 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                rows="2" placeholder="Masukkan komentar" required></textarea>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 mt-4 gap-4">
            <button type="submit"
                class="w-full text-white bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:bg-blue-400 disabled:cursor-not-allowed">
                Terima Logbook
            </button>
            <button type="submit"
                class="w-full text-white bg-red-600 hover:bg-red-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:bg-blue-400 disabled:cursor-not-allowed">
                Tolak Logbook
            </button>
        </div>

    </div>
</div>

<script>
    function displayFileName(input) {
        const fileName = input.files[0]?.name;
        document.getElementById('file-name').textContent = fileName || 'Upload lampiran';
    }
</script>
