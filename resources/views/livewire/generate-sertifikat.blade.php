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
                                <button wire:click="generateSertifikat('{{ $user->id }}')" wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50"
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-3 py-1.5 rounded">
                                    <span wire:loading.remove wire:target="generateSertifikat('{{ $user->id }}')">
                                        <i class="ti ti-file-plus"></i> Generate
                                    </span>
                                    <span wire:loading wire:target="generateSertifikat('{{ $user->id }}')">
                                        <i class="ti ti-loader animate-spin"></i> Loading...
                                    </span>
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
</div>