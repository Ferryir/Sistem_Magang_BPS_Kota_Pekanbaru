<div class="container mx-auto">
    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="ti ti-certificate-2 text-blue-500"></i>
            Generate Sertifikat Magang
        </h2>
        <p class="text-gray-600 text-sm mt-1">Generate sertifikat untuk peserta magang yang sudah dinilai</p>
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

    {{-- Search --}}
    <div class="mb-4">
        <input type="text" wire:model.live="search"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full md:w-1/3 p-2.5"
            placeholder="Cari nama peserta...">
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Nama Peserta</th>
                    <th class="px-4 py-3">Institusi</th>
                    <th class="px-4 py-3">Nilai Akhir</th>
                    <th class="px-4 py-3">Status Sertifikat</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->institusi }}</td>
                        <td class="px-4 py-3">
                            @if ($user->penilaian && $user->penilaian->nilai_akhir)
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ number_format($user->penilaian->nilai_akhir, 2) }}
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    Belum Dinilai
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if ($user->sertifikat)
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ $user->sertifikat->nomor_sertifikat }}
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    Belum Generate
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if ($user->sertifikat)
                                <a href="{{ asset('storage/' . $user->sertifikat->file_path) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                    <i class="ti ti-download"></i> Download
                                </a>
                            @elseif ($user->penilaian && $user->penilaian->nilai_akhir)
                                <button wire:click="openGenerateModal('{{ $user->id }}')"
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-3 py-1.5 rounded">
                                    <i class="ti ti-file-plus"></i> Generate
                                </button>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                            <i class="ti ti-users-minus text-4xl mb-2"></i>
                            <p>Tidak ada peserta magang</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Input Nomor Urut --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-black bg-opacity-50">
            <div class="relative bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
                {{-- Modal Header --}}
                <div class="flex items-center justify-between p-4 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="ti ti-certificate text-blue-500"></i>
                        Input Nomor Urut Sertifikat
                    </h3>
                    <button wire:click="closeModal" type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center">
                        <i class="ti ti-x text-xl"></i>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="p-4 space-y-4">
                    {{-- Info Format --}}
                    <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg text-sm">
                        <p class="font-medium mb-1"><i class="ti ti-info-circle"></i> Format Nomor Surat:</p>
                        <p class="font-mono">B-MMDDXXX/14.710/HM.340/YYYY</p>
                        <p class="text-xs mt-1 text-blue-600">XXX = Nomor urut yang akan Anda input</p>
                    </div>

                    {{-- Input Nomor Urut --}}
                    <div>
                        <label for="nomorUrut" class="block mb-2 text-sm font-medium text-gray-900">
                            Nomor urut: <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="nomorUrut" wire:model.live="nomorUrut"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('nomorUrut') border-red-500 @enderror"
                            placeholder="Contoh: 001, 002, 003, dst" min="1" max="999">
                        @error('nomorUrut')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Preview Nomor Sertifikat --}}
                    @if ($previewNomorSertifikat)
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                            <p class="text-sm font-medium mb-1"><i class="ti ti-eye"></i> Preview Nomor Sertifikat:</p>
                            <p class="font-mono font-bold text-lg">{{ $previewNomorSertifikat }}</p>
                        </div>
                    @endif
                </div>

                {{-- Modal Footer --}}
                <div class="flex items-center justify-end gap-2 p-4 border-t rounded-b">
                    <button wire:click="closeModal" type="button"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300">
                        Batal
                    </button>
                    <button wire:click="generateSertifikat" wire:loading.attr="disabled" wire:loading.class="opacity-50"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">
                        <span wire:loading.remove wire:target="generateSertifikat">
                            <i class="ti ti-file-certificate"></i> Generate Sertifikat
                        </span>
                        <span wire:loading wire:target="generateSertifikat">
                            <i class="ti ti-loader animate-spin"></i> Memproses...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>