<form class="space-y-4 " wire:submit.prevent="forgot_password">
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
    <button type="submit"
        class="w-full text-white bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:bg-blue-400 disabled:cursor-not-allowed">
        Reset
    </button>
    <div class="text-sm text-center text-gray-700">
        Kembali ke halaman sebelumnya? <a href="{{ url('/login') }}" class="text-blue-500 hover:underline">Masuk</a>
    </div>
</form>
