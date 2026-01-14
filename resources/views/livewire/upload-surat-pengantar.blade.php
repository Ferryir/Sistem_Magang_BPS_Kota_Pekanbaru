<form class="flex flex-col gap-5" wire:submit.prevent="upload_surat_pengantar">
    <div>
        <h6 class="text-[17px] mt-5 font-semibold text-gray-800">Surat Pengantar<span
            class="text-red-500 ml-1">*</span></h6>

        <div
            class="flex items-center px-2 py-3 mt-2 justify-between text-red-600 border-2 border-dashed border-gray-300 bg-gray-100 rounded-lg">
            <div class="flex items-center gap-2">
                <i class="ti ti-file-text text-2xl text-gray-700"></i>
                @if ($surat_pengantar)
                    <p class="text-gray-600 text-sm">{{ $surat_pengantar->getClientOriginalName() }}</p>
                @else
                    <p class="text-sm">dokumen belum di upload</p>
                @endif
            </div>
            @if ($surat_pengantar)
                <div class="flex items-center gap-2">
                    <button type="button"
                        class="px-3 py-2 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap"
                        onclick="openPreview('{{ $surat_pengantar ? $surat_pengantar->temporaryUrl() : Storage::url($pengajuan->surat_pengantar) }}')">
                        Lihat file
                    </button>
                    <div>
                        <input type="file" accept=".png, .jpg, .jpeg" name="surat_pengantar"
                            id="surat_pengantar" wire:model.live="surat_pengantar" class="hidden" />
                        <label for="surat_pengantar"
                            class="px-3 py-2 text-sm text-white bg-red-600 rounded-md font-medium transition-all duration-200 hover:bg-red-200 hover:text-red-600 whitespace-nowrap cursor-pointer">
                            Ganti file
                        </label>
                    </div>
                </div>
            @else
                <div>
                    <input type="file" accept=".png, .jpg, .jpeg" name="surat_pengantar" id="surat_pengantar"
                        wire:model.live="surat_pengantar" class="hidden" />
                    <label for="surat_pengantar"
                        class="px-3 py-2 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all cursor-pointer duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap">
                        Upload file
                    </label>
                </div>
            @endif
        </div>
        @error('surat_pengantar')
            <span class="text-red-600 text-[11px]">{{ $message }}</span>
        @enderror
    </div>
    <button id="submitBtn" type="submit"
        class="w-full text-white bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:cursor-not-allowed disabled:bg-blue-400">Upload Surat Pengantar
    </button>
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
