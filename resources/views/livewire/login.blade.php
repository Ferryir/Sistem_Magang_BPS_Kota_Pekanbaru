<form class="space-y-4 " wire:submit.prevent="login">
    <div>
        <label for="email" class="block mb-2 text-sm font-normal">
            Email</label>
        <input type="email" name="email" id="email" wire:model.live="email"
            class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]"
            placeholder="name@gmail.com" />
        @error('email')
            <span class="text-red-600 text-[11px]">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="password" class="block mb-2 text-sm font-normal">
            Password</label>
        <div class="relative group">
            <input type="password" name="password" id="password" placeholder="••••••••" wire:model.live="password"
                class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5 placeholder:text-[12px]" />
            <button type="button" onclick="togglePasswordVisibility('password')"
                class="absolute w-fit justify-center p-3 h-full right-0 top-0 flex items-center pr-3 text-gray-500 group-focus-within:text-blue-500">
                <i id="togglePasswordIcon_password" class="fas fa-eye"></i>
            </button>
        </div>
        @error('password')
            <span class="text-red-600 text-[11px]">{{ $message }}</span>
        @enderror
    </div>
    <div class="flex items-start">
        <div class="flex items-center h-5">
            <input id="remember" type="checkbox" name="remember" wire:model="remember"
                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300" />
        </div>
        <label for="remember" class="ms-2 text-sm font-normal text-gray-900">Remember me</label>
        <a href="{{ url('/forgot-password') }}" class="ms-auto text-sm text-blue-500 hover:underline">Lupa
            Password?</a>
    </div>
    <button type="submit"
        class="w-full text-white bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:bg-blue-400 disabled:cursor-not-allowed">
        Masuk
    </button>
    <div class="text-sm text-center text-gray-700">
        Masuk sebagai <a href="{{ url('/login-pegawai') }}" class="text-blue-500 hover:underline">Pembimbing</a>
    </div>
    <div class="text-sm text-center text-gray-700">
        Belum punya akun? <a href="{{ url('/registrasi') }}" class="text-blue-500 hover:underline">Registrasi</a>
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
</script>
