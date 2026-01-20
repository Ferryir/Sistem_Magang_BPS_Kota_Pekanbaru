<div class="container mx-auto">
    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="ti ti-certificate text-blue-500"></i>
            Penilaian Magang
        </h2>
        <p class="text-gray-600 text-sm mt-1">Form penilaian untuk peserta magang berdasarkan 5 aspek penilaian</p>
    </div>

    {{-- Success/Error Messages --}}
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4" role="alert">
            <i class="ti ti-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4" role="alert">
            <i class="ti ti-alert-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Form Container --}}
    <div class="bg-white rounded-lg shadow-md p-6">
        <form wire:submit.prevent="simpanPenilaian">
            {{-- Pilih Peserta Magang --}}
            <div class="mb-6">
                <label for="selectedUserId" class="block mb-2 text-md font-medium text-gray-700">
                    Pilih Peserta Magang <span class="text-red-500">*</span>
                </label>
                <select wire:model.live="selectedUserId" wire:change="loadPenilaian" id="selectedUserId"
                    class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5">
                    <option value="">-- Pilih Peserta --</option>
                    @foreach ($activeInterns as $intern)
                        <option value="{{ $intern->id }}">{{ $intern->name }} - {{ $intern->institusi }}</option>
                    @endforeach
                </select>
                @error('selectedUserId')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            @if ($selectedUserId)
                {{-- 5 Aspek Penilaian --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    {{-- Sikap dan Etika Kerja --}}
                    <div>
                        <label for="sikap_etika" class="block mb-1 text-md font-medium text-gray-700">
                            Sikap dan Etika Kerja <span class="text-red-500">*</span>
                        </label>
                        <input type="number" wire:model.live="sikap_etika" id="sikap_etika" min="0" max="100"
                            class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5"
                            placeholder="0-100" />
                        @error('sikap_etika')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Kemampuan Teknis --}}
                    <div>
                        <label for="kemampuan_teknis" class="block mb-1 text-md font-medium text-gray-700">
                            Kemampuan Teknis <span class="text-red-500">*</span>
                        </label>
                        <input type="number" wire:model.live="kemampuan_teknis" id="kemampuan_teknis" min="0" max="100"
                            class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5"
                            placeholder="0-100" />
                        @error('kemampuan_teknis')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Kemauan Belajar dan Adaptasi --}}
                    <div>
                        <label for="kemauan_belajar" class="block mb-1 text-md font-medium text-gray-700">
                            Kemauan Belajar dan Adaptasi <span class="text-red-500">*</span>
                        </label>
                        <input type="number" wire:model.live="kemauan_belajar" id="kemauan_belajar" min="0" max="100"
                            class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5"
                            placeholder="0-100" />
                        @error('kemauan_belajar')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Kualitas Hasil Kerja --}}
                    <div>
                        <label for="kualitas_kerja" class="block mb-1 text-md font-medium text-gray-700">
                            Kualitas Hasil Kerja <span class="text-red-500">*</span>
                        </label>
                        <input type="number" wire:model.live="kualitas_kerja" id="kualitas_kerja" min="0" max="100"
                            class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5"
                            placeholder="0-100" />
                        @error('kualitas_kerja')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Komunikasi dan Kerja Sama --}}
                    <div>
                        <label for="komunikasi_kerjasama" class="block mb-1 text-md font-medium text-gray-700">
                            Komunikasi dan Kerja Sama <span class="text-red-500">*</span>
                        </label>
                        <input type="number" wire:model.live="komunikasi_kerjasama" id="komunikasi_kerjasama" min="0"
                            max="100"
                            class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5"
                            placeholder="0-100" />
                        @error('komunikasi_kerjasama')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Nilai Akhir (Auto-calculated) --}}
                    <div>
                        <label for="nilai_akhir" class="block mb-1 text-md font-medium text-gray-700">
                            Nilai Akhir (Otomatis)
                        </label>
                        <input type="text" id="nilai_akhir" value="{{ $nilai_akhir }}" readonly
                            class="bg-blue-50 border border-blue-500 text-gray-900 text-lg font-bold rounded-lg w-full p-2.5 cursor-not-allowed"
                            placeholder="0.00" />
                    </div>
                </div>

                {{-- Catatan Tambahan --}}
                <div class="mb-6">
                    <label for="catatan" class="block mb-1 text-md font-medium text-gray-700">
                        Catatan Tambahan (Opsional)
                    </label>
                    <textarea wire:model="catatan" id="catatan" rows="3"
                        class="bg-gray-50 border border-gray-500 outline-none text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-2 w-full p-2.5"
                        placeholder="Tambahkan catatan atau feedback untuk peserta..."></textarea>
                    @error('catatan')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-2.5 text-white bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm">
                        <i class="ti ti-device-floppy mr-1"></i>
                        Simpan Penilaian
                    </button>
                </div>
            @else
                <div class="text-center py-10 text-gray-400">
                    <i class="ti ti-user-search text-6xl mb-3"></i>
                    <p>Pilih peserta magang untuk mulai menilai</p>
                </div>
            @endif
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputs = document.querySelectorAll('input[type="number"]');
        inputs.forEach(input => {
            input.addEventListener('input', function () {
                if (parseInt(this.value) > 100) {
                    this.value = 100;
                }
                if (parseInt(this.value) < 0) {
                    this.value = 0;
                }
            });
        });
    });

    // Re-apply after Livewire updates
    document.addEventListener('livewire:updated', function () {
        const inputs = document.querySelectorAll('input[type="number"]');
        inputs.forEach(input => {
            input.addEventListener('input', function () {
                if (parseInt(this.value) > 100) {
                    this.value = 100;
                }
                if (parseInt(this.value) < 0) {
                    this.value = 0;
                }
            });
        });
    });
</script>