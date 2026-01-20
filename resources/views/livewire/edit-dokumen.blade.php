<form class="flex flex-col gap-5" wire:submit.prevent="update_dokumen">
    <div class="grid md:grid-cols-1 gap-4">

        <div>
            <h6 class="text-[17px] font-semibold text-gray-800">Kartu Tanda Penduduk<span
                    class="text-red-500 ml-1">*</span></h6>
            @if (!empty(Auth::user()->kartu_penduduk))
                <div
                    class="flex flex-col md:flex-row items-center px-2 py-3 mt-2 justify-between text-red-600 border-2 border-dashed border-gray-300 bg-gray-100 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-file-text text-2xl text-gray-700"></i>
                        <p class="text-gray-600 text-sm">
                            {{ $kartu_penduduk ? $kartu_penduduk->getClientOriginalName() : Auth::user()->original_filename_ktp }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button"
                            class="px-3 py-2 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap"
                            onclick="openPreview('{{ $kartu_penduduk ? $kartu_penduduk->temporaryUrl() : Storage::url(Auth::user()->kartu_penduduk) }}')">
                            Lihat file
                        </button>
                        <div>
                            <input type="file" accept=".png, .jpg, .jpeg" name="kartu_penduduk" id="kartu_penduduk"
                                wire:model.live="kartu_penduduk" class="hidden" />
                            <label for="kartu_penduduk"
                                class="px-3 py-2 text-sm text-white bg-red-600 rounded-md font-medium transition-all duration-200 hover:bg-red-200 hover:text-red-600 whitespace-nowrap cursor-pointer">
                                Ganti file
                            </label>
                        </div>
                    </div>
                </div>
            @else
                <div
                    class="flex items-center px-2 py-3 mt-2 justify-between text-red-600 border-2 border-dashed border-gray-300 bg-gray-100 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-file-text text-2xl text-gray-700"></i>
                        @if ($kartu_penduduk)
                            <p class="text-gray-600 text-sm">{{ $kartu_penduduk->getClientOriginalName() }}</p>
                        @else
                            <p class="text-sm">dokumen belum di upload</p>
                        @endif
                    </div>
                    @if ($kartu_penduduk)
                        <div class="flex items-center gap-2">
                            <button type="button"
                                class="px-3 py-2 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap"
                                onclick="openPreview('{{ $kartu_penduduk ? $kartu_penduduk->temporaryUrl() : Storage::url(Auth::user()->kartu_penduduk) }}')">
                                Lihat file
                            </button>
                            <div>
                                <input type="file" accept=".png, .jpg, .jpeg" name="kartu_penduduk" id="kartu_penduduk"
                                    wire:model.live="kartu_penduduk" class="hidden" />
                                <label for="kartu_penduduk"
                                    class="px-3 py-2 text-sm text-white bg-red-600 rounded-md font-medium transition-all duration-200 hover:bg-red-200 hover:text-red-600 whitespace-nowrap cursor-pointer">
                                    Ganti file
                                </label>
                            </div>
                        </div>
                    @else
                        <div>
                            <input type="file" accept=".png, .jpg, .jpeg" name="kartu_penduduk" id="kartu_penduduk"
                                wire:model.live="kartu_penduduk" class="hidden" />
                            <label for="kartu_penduduk"
                                class="px-3 py-2 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all cursor-pointer duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap">
                                Upload file
                            </label>
                        </div>
                    @endif
                </div>
            @endif
            @error('kartu_penduduk')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <h6 class="text-[17px] font-semibold text-gray-800">Kartu Tanda Siswa/Mahasiswa <span
                    class="text-gray-500 font-normal text-sm">(Opsional)</span></h6>

            @if (!empty(Auth::user()->kartu_tanda))
                <div
                    class="flex flex-col md:flex-row items-center px-2 py-3 mt-2 justify-between text-red-600 border-2 border-dashed border-gray-300 bg-gray-100 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-file-text text-2xl text-gray-700"></i>
                        <p class="text-gray-600 text-sm">
                            {{ $kartu_tanda ? $kartu_tanda->getClientOriginalName() : Auth::user()->original_filename_kartu }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button"
                            class="px-3 py-2 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap"
                            onclick="openPreview('{{ $kartu_tanda ? $kartu_tanda->temporaryUrl() : Storage::url(Auth::user()->kartu_tanda) }}')">
                            Lihat file
                        </button>
                        <div>
                            <input type="file" accept=".png, .jpg, .jpeg" name="kartu_tanda" id="kartu_tanda"
                                wire:model.live="kartu_tanda" class="hidden" />
                            <label for="kartu_tanda"
                                class="px-3 py-2 text-sm text-white bg-red-600 rounded-md font-medium transition-all duration-200 hover:bg-red-200 hover:text-red-600 whitespace-nowrap cursor-pointer">
                                Ganti file
                            </label>
                        </div>
                    </div>
                </div>
            @else
                <div
                    class="flex items-center px-2 py-3 mt-2 justify-between text-red-600 border-2 border-dashed border-gray-300 bg-gray-100 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-file-text text-2xl text-gray-700"></i>
                        @if ($kartu_tanda)
                            <p class="text-gray-600 text-sm">{{ $kartu_tanda->getClientOriginalName() }}</p>
                        @else
                            <p class="text-sm">dokumen belum di upload</p>
                        @endif
                    </div>
                    @if ($kartu_tanda)
                        <div class="flex items-center gap-2">
                            <button type="button"
                                class="px-3 py-2 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap"
                                onclick="openPreview('{{ $kartu_tanda ? $kartu_tanda->temporaryUrl() : Storage::url(Auth::user()->kartu_tanda) }}')">
                                Lihat file
                            </button>
                            <div>
                                <input type="file" accept=".png, .jpg, .jpeg" name="kartu_tanda" id="kartu_tanda"
                                    wire:model.live="kartu_tanda" class="hidden" />
                                <label for="kartu_tanda"
                                    class="px-3 py-2 text-sm text-white bg-red-600 rounded-md font-medium transition-all duration-200 hover:bg-red-200 hover:text-red-600 whitespace-nowrap cursor-pointer">
                                    Ganti file
                                </label>
                            </div>
                        </div>
                    @else
                        <div>
                            <input type="file" accept=".png, .jpg, .jpeg" name="kartu_tanda" id="kartu_tanda"
                                wire:model.live="kartu_tanda" class="hidden" />
                            <label for="kartu_tanda"
                                class="px-3 py-2 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all cursor-pointer duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap">
                                Upload file
                            </label>
                        </div>
                    @endif
                </div>
            @endif
            @error('kartu_tanda')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

    </div>
    <button id="submitBtn" type="submit"
        class="w-full text-white bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:cursor-not-allowed disabled:bg-blue-400">Perbarui
        Dokumen</button>
</form>

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