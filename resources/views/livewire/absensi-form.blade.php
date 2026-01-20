<div>
    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="w-full flex gap-3 items-center p-3 mb-4 bg-green-100 rounded-lg border text-green-700 border-green-700">
            <i class="ti ti-check text-lg"></i>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="w-full flex gap-3 items-center p-3 mb-4 bg-red-100 rounded-lg border text-red-700 border-red-700">
            <i class="ti ti-alert-circle text-lg"></i>
            <p class="text-sm">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Calendar Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ $monthName }}</h1>
        <div class="flex items-center gap-2">
            <button wire:click="goToToday"
                class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-all text-sm font-medium">
                Today
            </button>
            <button wire:click="previousMonth" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all">
                <i class="ti ti-chevron-left text-gray-600"></i>
            </button>
            <button wire:click="nextMonth" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all">
                <i class="ti ti-chevron-right text-gray-600"></i>
            </button>
        </div>
    </div>

    {{-- Calendar Grid --}}
    <div class="border border-gray-200 rounded-lg overflow-hidden">
        {{-- Days Header --}}
        <div class="grid grid-cols-7 bg-gray-50 border-b border-gray-200">
            @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                <div
                    class="py-3 text-center text-sm font-semibold text-gray-600 {{ in_array($day, ['Sun', 'Sat']) ? 'text-gray-400' : '' }}">
                    {{ $day }}
                </div>
            @endforeach
        </div>

        {{-- Calendar Days --}}
        @foreach($calendarData as $week)
            <div class="grid grid-cols-7 border-b border-gray-200 last:border-b-0">
                @foreach($week as $day)
                    <div
                        class="min-h-[120px] p-2 border-r border-gray-200 last:border-r-0 {{ !$day['isCurrentMonth'] ? 'bg-gray-50' : '' }} {{ $day['isToday'] ? 'bg-blue-50' : '' }}">
                        {{-- Date Number --}}
                        <div class="flex justify-end mb-1">
                            <span
                                class="text-sm {{ !$day['isCurrentMonth'] ? 'text-gray-300' : ($day['isWeekend'] ? 'text-gray-400' : 'text-gray-600') }} {{ $day['isToday'] ? 'bg-blue-500 text-white px-2 py-0.5 rounded-full' : '' }}">
                                {{ $day['day'] }}
                            </span>
                        </div>

                        {{-- Content --}}
                        @if($day['isInternshipPeriod'] && $day['isCurrentMonth'] && !$day['isWeekend'])
                            @if($day['absensi'])
                                {{-- Already submitted --}}
                                @if($day['isToday'])
                                    {{-- Only allow editing if it's today --}}
                                    <div wire:click="openModal('{{ $day['dateKey'] }}')" class="cursor-pointer">
                                        <div class="bg-white border border-gray-200 rounded-md p-2 mb-1 hover:shadow-sm transition-all">
                                            <p class="text-xs font-medium text-gray-700 truncate">Daily check-in</p>
                                        </div>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs border {{ $day['absensi']->verifikasi ? 'text-green-600 border-green-500 bg-green-50' : 'text-orange-600 border-orange-500 bg-orange-50' }}">
                                            {{ $day['absensi']->verifikasi ? 'Submitted' : 'Not Submitted' }}
                                        </span>
                                    </div>
                                @else
                                    {{-- Past date - view only, no click --}}
                                    <div class="opacity-75">
                                        <div class="bg-gray-50 border border-gray-200 rounded-md p-2 mb-1">
                                            <p class="text-xs font-medium text-gray-500 truncate">Daily check-in</p>
                                        </div>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs border {{ $day['absensi']->verifikasi ? 'text-green-600 border-green-500 bg-green-50' : 'text-orange-600 border-orange-500 bg-orange-50' }}">
                                            {{ $day['absensi']->verifikasi ? 'Submitted' : 'Not Submitted' }}
                                        </span>
                                    </div>
                                @endif
                            @elseif($day['isToday'])
                                {{-- Today but not submitted yet - allow click --}}
                                <div wire:click="openModal('{{ $day['dateKey'] }}')" class="cursor-pointer">
                                    <div class="bg-white border border-gray-200 rounded-md p-2 mb-1 hover:shadow-sm transition-all">
                                        <p class="text-xs font-medium text-gray-400 truncate">Daily check-in</p>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs text-red-600 border border-red-400 bg-red-50">
                                        Not Submitted
                                    </span>
                                </div>
                            @elseif(!$day['isFuture'])
                                {{-- Past date not submitted - show as missed, no click --}}
                                <div class="opacity-60">
                                    <div class="bg-red-50 border border-red-200 rounded-md p-2 mb-1">
                                        <p class="text-xs font-medium text-red-400 truncate">Daily check-in</p>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs text-red-500 border border-red-300 bg-red-50">
                                        Missed
                                    </span>
                                </div>
                            @else
                                {{-- Future date --}}
                                <div class="opacity-50">
                                    <div class="bg-gray-100 border border-gray-200 rounded-md p-2 mb-1">
                                        <p class="text-xs font-medium text-gray-400 truncate">Daily check-in</p>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs text-gray-400 border border-gray-300">
                                        Upcoming
                                    </span>
                                </div>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    {{-- Modal --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            wire:click.self="closeModal">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto">
                <div class="p-5 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">
                            {{ $isEditing ? 'Edit Presensi' : 'Isi Presensi' }} -
                            {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('j F Y') }}
                        </h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <i class="ti ti-x text-xl"></i>
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="submit" class="p-5">
                    {{-- Status Kehadiran --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Kehadiran <span
                                class="text-red-500">*</span></label>
                        <div class="flex flex-wrap gap-4">
                            <label
                                class="flex items-center gap-2 cursor-pointer px-4 py-2 rounded-lg border {{ $status == 'hadir' ? 'border-green-500 bg-green-50' : 'border-gray-300 bg-white' }} hover:bg-green-50 transition-all">
                                <input type="radio" wire:model="status" value="hadir"
                                    class="w-4 h-4 text-green-600 focus:ring-green-500">
                                <span
                                    class="text-sm {{ $status == 'hadir' ? 'text-green-700 font-medium' : 'text-gray-700' }}">
                                    <i class="ti ti-check mr-1"></i>Hadir
                                </span>
                            </label>
                            <label
                                class="flex items-center gap-2 cursor-pointer px-4 py-2 rounded-lg border {{ $status == 'izin' ? 'border-blue-500 bg-blue-50' : 'border-gray-300 bg-white' }} hover:bg-blue-50 transition-all">
                                <input type="radio" wire:model="status" value="izin"
                                    class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                <span
                                    class="text-sm {{ $status == 'izin' ? 'text-blue-700 font-medium' : 'text-gray-700' }}">
                                    <i class="ti ti-mail mr-1"></i>Izin
                                </span>
                            </label>
                            <label
                                class="flex items-center gap-2 cursor-pointer px-4 py-2 rounded-lg border {{ $status == 'sakit' ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-white' }} hover:bg-red-50 transition-all">
                                <input type="radio" wire:model="status" value="sakit"
                                    class="w-4 h-4 text-red-600 focus:ring-red-500">
                                <span
                                    class="text-sm {{ $status == 'sakit' ? 'text-red-700 font-medium' : 'text-gray-700' }}">
                                    <i class="ti ti-first-aid-kit mr-1"></i>Sakit
                                </span>
                            </label>
                        </div>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Uraian Aktivitas --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Uraian Aktivitas <span
                                class="text-red-500">*</span></label>
                        <textarea wire:model="uraian_aktivitas" rows="3"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('uraian_aktivitas') border-red-500 @enderror"
                            placeholder="Jelaskan aktivitas yang dilakukan hari ini..."></textarea>
                        @error('uraian_aktivitas')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Pembelajaran yang Diperoleh --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pembelajaran yang Diperoleh <span
                                class="text-red-500">*</span></label>
                        <textarea wire:model="pembelajaran_diperoleh" rows="3"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('pembelajaran_diperoleh') border-red-500 @enderror"
                            placeholder="Jelaskan pembelajaran yang diperoleh hari ini..."></textarea>
                        @error('pembelajaran_diperoleh')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kendala yang Dialami --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kendala yang Dialami</label>
                        <textarea wire:model="kendala_dialami" rows="2"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Jelaskan kendala yang dialami jika ada (opsional)..."></textarea>
                    </div>

                    {{-- Verifikasi Checkbox --}}
                    <div class="mb-5 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" wire:model="verifikasi"
                                class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 @error('verifikasi') border-red-500 @enderror">
                            <span class="text-sm text-gray-700">
                                Saya menyatakan telah meninjau dan memastikan isian laporan ini sudah benar
                            </span>
                        </label>
                        @error('verifikasi')
                            <p class="text-red-500 text-xs mt-1 ml-7">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end gap-3">
                        <button type="button" wire:click="closeModal"
                            class="px-4 py-2 text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 transition-all">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all flex items-center gap-2">
                            <span wire:loading.remove wire:target="submit">{{ $isEditing ? 'Perbarui' : 'Simpan' }}</span>
                            <span wire:loading wire:target="submit">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>