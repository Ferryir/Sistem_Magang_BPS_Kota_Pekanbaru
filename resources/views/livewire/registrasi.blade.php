<form class="space-y-4 bg-white shadow px-7 py-7 rounded-lg flex flex-col gap-3" wire:submit="create_user">
    
    <div>
        <h1 class="font-semibold text-2xl text-gray-800">Registrasi Akun</h1>
    </div>
    
    <div class="grid md:grid-cols-2 gap-4">

        <div>
            <label for="name" class="block mb-1 text-sm font-normal">Nama</label>
            <input type="text" name="name" id="nama" wire:model.live="name"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]"
                placeholder="Masukkan nama lengkap" />
            @error('name')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="email" class="block mb-1 text-sm font-normal">Email</label>
            <input type="email" name="email" id="email" wire:model.live="email" placeholder="name@gmail.com"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
            @error('email')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="nomor_induk" class="block mb-1 text-sm font-normal">Nomor Induk
                Siswa/Mahasiswa</label>
            <input type="number" name="nomor_induk" id="nomor_induk" min="0" wire:model.live="nomor_induk"
                placeholder="Masukkan nomor induk"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
            @error('nomor_induk')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="institusi" class="block mb-1 text-sm font-normal">Asal Institusi</label>
            <input type="text" name="institusi" id="institusi" min="0" wire:model.live="institusi"
                placeholder="Masukkan asal institusi"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
            @error('institusi')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="jurusan" class="block mb-1 text-sm font-normal">Jurusan</label>
            <input type="text" name="jurusan" id="jurusan" min="0" wire:model.live="jurusan"
                placeholder="Masukkan jurusan"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
            @error('jurusan')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div class="row-span-2 h-[24vh] md:h-full">
            <label for="kartu_tanda" class="block mb-1 text-sm font-normal whitespace-nowrap">Kartu Tanda
                Siswa/Mahasiswa</label>
            <div class="flex gap-3 h-[85%]">
                <div id="file-path"
                    class="relative bg-gray-50 w-full border border-gray-500 outline-none text-gray-400 text-sm rounded-lg overflow-hidden">
                    <p id="text-holder"
                        class="absolute w-full inset-0 flex items-center justify-start ml-2 pointer-events-none text-[12px]">
                        Upload scan kartu siswa/mahasiswa
                    </p>
                    @if ($kartu_tanda)
                        <img src="{{ $kartu_tanda->temporaryUrl() }}" alt="Preview"
                            class="absolute inset-0 object-cover w-full h-full mx-auto cursor-pointer"
                            onclick="openPreview('{{ $kartu_tanda->temporaryUrl() }}')" />
                    @endif
                </div>
                <input type="file" accept=".png, .jpg, .jpeg" name="kartu_tanda" id="kartu_tanda"
                    wire:model.live="kartu_tanda" class="hidden" />
                <label for="kartu_tanda"
                    class="bg-blue-600 text-white w-12 rounded-lg cursor-pointer flex items-center justify-center hover:bg-blue-700 transition duration-300 ease-in-out">
                    <i class="fas fa-upload"></i>
                </label>
            </div>
            @error('kartu_tanda')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="nomor_hp" class="block mb-1 text-sm font-normal">Nomor HP</label>
            <input type="number" min="0" name="nomor_hp" id="nomor_hp" wire:model.live="nomor_hp"
                placeholder="Masukkan nomor HP"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
            @error('nomor_hp')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-1">
            <label for="password" class="block mb-1 text-sm font-normal">Password</label>
            <div class="relative group">
                <input type="password" name="password" id="password" placeholder="Masukkan password"
                    wire:model.live="password"
                    class="bg-gray-50 pr-10 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
                <button type="button" onclick="togglePasswordVisibility('password')"
                    class="absolute w-fit justify-center p-3 h-full right-0 top-0 flex items-center pr-3 text-gray-500 group-focus-within:text-blue-500">
                    <i id="togglePasswordIcon_password" class="fas fa-eye"></i>
                </button>
            </div>
            @if ($errors->has('password'))
                <ul class="list-disc pl-5 text-red-600 text-[11px] mt-2">
                    @foreach ($errors->get('password') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="mt-1">
            <label for="confirm_password" class="block mb-1 text-sm font-normal">Konfirmasi Password</label>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Konfirmasi password"
                wire:model.live="confirm_password"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
            @error('confirm_password')
                <span class="text-red-600 text-[11px]">{{ $message }}</span>
            @enderror
        </div>

    </div>

    <div class="flex flex-col justify-start w-full gap-2">
        <div class="flex gap-2 items-center">
            <input id="checkbox1" type="checkbox" onchange="toggleSubmitButton()"
                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300">
            <p class="text-[12px]">Apakah kamu sudah yakin semua data diisi dengan benar?</p>
        </div>
        <div class="flex gap-2 items-center">
            <input id="checkbox2" type="checkbox" onchange="toggleSubmitButton()"
                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300">
            <p class="text-[12px]">Data yang dimasukkan adalah benar milik kamu?</p>
        </div>
    </div>

    <button id="submitBtn" type="submit" disabled
        class="w-full text-white bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:cursor-not-allowed disabled:bg-blue-400">Daftar
        akun</button>
    <div class="text-sm !mt-0 text-center text-gray-700">
        Sudah punya akun? <a href="{{ url('/login') }}" class="text-blue-500 hover:underline">Masuk</a>
    </div>

</form>

<script>
    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById('togglePasswordIcon_' + fieldId);
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

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

    function toggleSubmitButton() {
        var checkbox1 = document.getElementById('checkbox1');
        var checkbox2 = document.getElementById('checkbox2');
        var submitBtn = document.getElementById('submitBtn');

        if (checkbox1.checked && checkbox2.checked) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }
</script>
