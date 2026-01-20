<form class="flex flex-col gap-5" wire:submit="update_akademik">

    <div class="grid md:grid-cols-1 gap-4">
        <div>
            <label for="institusi" class="block mb-1 text-md font-medium text-gray-700">Asal Institusi<span
                    class="text-red-500 ml-1">*</span></label>
            <input type="text" name="institusi" id="institusi" min="0" wire:model.live="institusi"
                placeholder="Masukkan asal institusi"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
            @error('institusi')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="jurusan" class="block mb-1 text-md font-medium text-gray-700">Jurusan<span
                    class="text-red-500 ml-1">*</span></label>
            <input type="text" name="jurusan" id="jurusan" min="0" wire:model.live="jurusan"
                placeholder="Masukkan jurusan"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
            @error('jurusan')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="prodi" class="block mb-1 text-md font-medium text-gray-700">Program Studi (Prodi)<span
                    class="text-red-500 ml-1">*</span></label>
            <input type="text" name="prodi" id="prodi" min="0" wire:model.live="prodi"
                placeholder="Masukkan program studi"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
            @error('prodi')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="semester" class="block mb-1 text-md font-medium text-gray-700">Semester<span
                    class="text-red-500 ml-1">*</span></label>
            <input type="number" name="semester" id="semester" min="1" wire:model.live="semester" placeholder="Semester"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
            @error('semester')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="nomor_induk" class="block mb-1 text-md font-medium text-gray-700">Nomor Induk
                Siswa/Mahasiswa<span class="text-red-500 ml-1">*</span></label>
            <input type="number" name="nomor_induk" id="nomor_induk" min="0" wire:model.live="nomor_induk"
                placeholder="Masukkan nomor induk"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
            @error('nomor_induk')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

    </div>
    <button id="submitBtn" type="submit"
        class="w-full text-white bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:cursor-not-allowed disabled:bg-blue-400">Perbarui
        Data Akademik
    </button>

</form>