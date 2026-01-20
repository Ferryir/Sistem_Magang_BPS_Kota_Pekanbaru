@php
    use Carbon\Carbon;
@endphp
<div>
    {{-- Header --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Monitor Presensi Magang</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Sidebar: List of Interns --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Daftar Peserta Magang</h2>

                {{-- Search --}}
                <div class="relative mb-4">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="ti ti-search text-lg text-gray-500"></i>
                    </div>
                    <input wire:model.live="search" type="text"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2"
                        placeholder="Cari nama peserta...">
                </div>

                {{-- Intern List --}}
                <div class="space-y-2 max-h-[500px] overflow-y-auto">
                    @forelse ($interns as $intern)
                        <button wire:click="selectIntern('{{ $intern->id }}')"
                            class="w-full flex items-center gap-3 p-3 rounded-lg transition-all text-left
                                                    {{ $selectedInternId == $intern->id ? 'bg-blue-100 border-blue-500 border' : 'bg-gray-50 hover:bg-gray-100 border border-transparent' }}">
                            <div
                                class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr($intern->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-800 truncate">{{ $intern->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $intern->institusi ?? 'Tidak ada institusi' }}
                                </p>
                            </div>
                            @if($selectedInternId == $intern->id)
                                <i class="ti ti-chevron-right text-blue-500"></i>
                            @endif
                        </button>
                    @empty
                        <div class="text-center py-8 text-gray-400">
                            <i class="ti ti-users-off text-4xl"></i>
                            <p class="mt-2">Tidak ada peserta magang aktif</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Main Content: Attendance Detail --}}
        <div class="lg:col-span-2">
            @if($selectedInternData)
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    {{-- Intern Info Header --}}
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-14 h-14 rounded-full bg-blue-500 flex items-center justify-center text-white text-xl font-semibold">
                                {{ strtoupper(substr($selectedInternData['user']->name, 0, 1)) }}
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">{{ $selectedInternData['user']->name }}</h2>
                                <p class="text-sm text-gray-500">{{ $selectedInternData['user']->email }}</p>
                                @if($selectedInternData['pengajuan'])
                                    <p class="text-xs text-gray-400 mt-1">
                                        Periode:
                                        {{ Carbon::parse($selectedInternData['pengajuan']->tanggal_mulai)->format('j M Y') }} -
                                        {{ Carbon::parse($selectedInternData['pengajuan']->tanggal_selesai)->format('j M Y') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <button wire:click="clearSelection" class="text-gray-400 hover:text-gray-600">
                            <i class="ti ti-x text-xl"></i>
                        </button>
                    </div>

                    {{-- Stats Cards --}}
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-center">
                            <p class="text-2xl font-bold text-blue-600">{{ $selectedInternData['stats']['total_required'] }}
                            </p>
                            <p class="text-xs text-blue-500">Total Hari Kerja</p>
                        </div>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3 text-center">
                            <p class="text-2xl font-bold text-green-600">{{ $selectedInternData['stats']['hadir'] }}</p>
                            <p class="text-xs text-green-500">Hadir</p>
                        </div>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-center">
                            <p class="text-2xl font-bold text-yellow-600">{{ $selectedInternData['stats']['izin'] }}</p>
                            <p class="text-xs text-yellow-500">Izin</p>
                        </div>
                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-3 text-center">
                            <p class="text-2xl font-bold text-orange-600">{{ $selectedInternData['stats']['sakit'] }}</p>
                            <p class="text-xs text-orange-500">Sakit</p>
                        </div>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-center">
                            <p class="text-2xl font-bold text-red-600">{{ $selectedInternData['stats']['missed'] }}</p>
                            <p class="text-xs text-red-500">Tidak Hadir</p>
                        </div>
                    </div>

                    {{-- Calendar Navigation --}}
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $monthName }}</h3>
                        <div class="flex items-center gap-2">
                            <button wire:click="goToToday"
                                class="px-3 py-1.5 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all text-sm font-medium">
                                Hari Ini
                            </button>
                            <button wire:click="previousMonth"
                                class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all">
                                <i class="ti ti-chevron-left text-gray-600"></i>
                            </button>
                            <button wire:click="nextMonth"
                                class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all">
                                <i class="ti ti-chevron-right text-gray-600"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Calendar Grid --}}
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        {{-- Days Header --}}
                        <div class="grid grid-cols-7 bg-gray-50 border-b border-gray-200">
                            @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
                                <div
                                    class="py-2 text-center text-xs font-semibold text-gray-600 {{ in_array($day, ['Min', 'Sab']) ? 'text-gray-400' : '' }}">
                                    {{ $day }}
                                </div>
                            @endforeach
                        </div>

                        {{-- Calendar Days --}}
                        @foreach($selectedInternData['calendarData'] as $week)
                            <div class="grid grid-cols-7 border-b border-gray-200 last:border-b-0">
                                @foreach($week as $day)
                                    <div
                                        class="min-h-[70px] p-1.5 border-r border-gray-200 last:border-r-0 
                                                                                                    {{ !$day['isCurrentMonth'] ? 'bg-gray-50' : '' }} 
                                                                                                    {{ $day['isToday'] ? 'bg-blue-50' : '' }}">
                                        {{-- Date Number --}}
                                        <div class="flex justify-end mb-1">
                                            <span
                                                class="text-xs {{ !$day['isCurrentMonth'] ? 'text-gray-300' : ($day['isWeekend'] ? 'text-gray-400' : 'text-gray-600') }} 
                                                                                                            {{ $day['isToday'] ? 'bg-blue-500 text-white px-1.5 py-0.5 rounded-full' : '' }}">
                                                {{ $day['day'] }}
                                            </span>
                                        </div>

                                        {{-- Content --}}
                                        @if($day['isInternshipPeriod'] && $day['isCurrentMonth'] && !$day['isWeekend'])
                                            @if($day['absensi'])
                                                {{-- Attendance Status Badge --}}
                                                @php
                                                    $statusColors = [
                                                        'hadir' => 'bg-green-100 text-green-700 border-green-300',
                                                        'izin' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                                                        'sakit' => 'bg-orange-100 text-orange-700 border-orange-300',
                                                    ];
                                                    $statusLabels = [
                                                        'hadir' => 'Hadir',
                                                        'izin' => 'Izin',
                                                        'sakit' => 'Sakit',
                                                    ];
                                                    $statusIcons = [
                                                        'hadir' => 'ti-check',
                                                        'izin' => 'ti-mail',
                                                        'sakit' => 'ti-first-aid-kit',
                                                    ];
                                                @endphp
                                                <div class="text-center">
                                                    <span
                                                        class="inline-flex items-center justify-center gap-1 px-1.5 py-0.5 rounded text-xs border {{ $statusColors[$day['absensi']->status] ?? 'bg-gray-100 text-gray-600' }}">
                                                        <i
                                                            class="ti {{ $statusIcons[$day['absensi']->status] ?? 'ti-circle' }} text-xs"></i>
                                                        <span
                                                            class="hidden md:inline">{{ $statusLabels[$day['absensi']->status] ?? $day['absensi']->status }}</span>
                                                    </span>
                                                    @if($day['absensi']->verifikasi)
                                                        <div class="mt-1">
                                                            <span class="text-[10px] text-green-600"><i class="ti ti-circle-check"></i></span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @elseif(!$day['isFuture'])
                                                {{-- Missed --}}
                                                <div class="text-center">
                                                    <span
                                                        class="inline-flex items-center justify-center gap-1 px-1.5 py-0.5 rounded text-xs bg-red-100 text-red-600 border border-red-300">
                                                        <i class="ti ti-x text-xs"></i>
                                                        <span class="hidden md:inline">Tidak Hadir</span>
                                                    </span>
                                                </div>
                                            @else
                                                {{-- Future --}}
                                                <div class="text-center opacity-40">
                                                    <span
                                                        class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-gray-100 text-gray-500 border border-gray-200">
                                                        <i class="ti ti-clock text-xs"></i>
                                                    </span>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    {{-- Legend --}}
                    <div class="mt-4 flex flex-wrap items-center gap-4 text-xs text-gray-600">
                        <span class="font-semibold">Keterangan:</span>
                        <span class="flex items-center gap-1">
                            <span class="w-3 h-3 rounded bg-green-100 border border-green-300"></span> Hadir
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="w-3 h-3 rounded bg-yellow-100 border border-yellow-300"></span> Izin
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="w-3 h-3 rounded bg-orange-100 border border-orange-300"></span> Sakit
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="w-3 h-3 rounded bg-red-100 border border-red-300"></span> Tidak Hadir
                        </span>
                        </span>
                    </div>

                    {{-- Detail Presensi Table --}}
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center gap-2">
                            <i class="ti ti-list-details text-blue-500"></i>
                            Detail Presensi Bulan Ini
                        </h4>
                        <div class="bg-gray-50 rounded-lg border border-gray-200 overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                        <tr>
                                            <th class="px-4 py-3">Tanggal</th>
                                            <th class="px-4 py-3 text-center">Status</th>
                                            <th class="px-4 py-3">Uraian Aktivitas</th>
                                            <th class="px-4 py-3">Pembelajaran yang Diperoleh</th>
                                            <th class="px-4 py-3">Kendala yang Dialami</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $hasData = false;
                                        @endphp
                                        @foreach($selectedInternData['calendarData'] as $week)
                                            @foreach($week as $day)
                                                @if($day['isInternshipPeriod'] && $day['isCurrentMonth'] && !$day['isWeekend'] && $day['absensi'])
                                                                            @php $hasData = true; @endphp
                                                                            <tr class="bg-white border-b hover:bg-gray-50">
                                                                                <td class="px-4 py-3 whitespace-nowrap font-medium">
                                                                                    {{ $day['date']->translatedFormat('j M Y') }}
                                                                                </td>
                                                                                <td class="px-4 py-3 text-center">
                                                                                    @php
                                                                                        $statusColors = [
                                                                                            'hadir' => 'bg-green-100 text-green-700 border-green-300',
                                                                                            'izin' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                                                                                            'sakit' => 'bg-orange-100 text-orange-700 border-orange-300',
                                                                                        ];
                                                                                        $statusLabels = [
                                                                                            'hadir' => 'Hadir',
                                                                                            'izin' => 'Izin',
                                                                                            'sakit' => 'Sakit',
                                                                                        ];
                                                                                    @endphp
                                                    <span
                                                                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs border {{ $statusColors[$day['absensi']->status] ?? 'bg-gray-100 text-gray-600' }}">
                                                                                        {{ $statusLabels[$day['absensi']->status] ?? ucfirst($day['absensi']->status) }}
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-4 py-3">
                                                                                    <p class="text-gray-700 max-w-xs"
                                                                                        title="{{ $day['absensi']->uraian_aktivitas }}">
                                                                                        {{ Str::limit($day['absensi']->uraian_aktivitas, 100) ?? '-' }}
                                                                                    </p>
                                                                                </td>
                                                                                <td class="px-4 py-3">
                                                                                    <p class="text-gray-700 max-w-xs"
                                                                                        title="{{ $day['absensi']->pembelajaran_diperoleh }}">
                                                                                        {{ Str::limit($day['absensi']->pembelajaran_diperoleh, 100) ?? '-' }}
                                                                                    </p>
                                                                                </td>
                                                                                <td class="px-4 py-3">
                                                                                    <p class="text-gray-500 max-w-xs"
                                                                                        title="{{ $day['absensi']->kendala_dialami }}">
                                                                                        {{ Str::limit($day['absensi']->kendala_dialami, 100) ?? '-' }}
                                                                                    </p>
                                                                                </td>
                                                                            </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                        @if(!$hasData)
                                            <tr class="bg-white">
                                                <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                                                    <i class="ti ti-file-x text-3xl"></i>
                                                    <p class="mt-2">Belum ada data presensi bulan ini</p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- No selection placeholder --}}
                <div
                    class="bg-white rounded-lg border border-gray-200 p-8 flex flex-col items-center justify-center min-h-[400px]">
                    <i class="ti ti-calendar-stats text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">Pilih Peserta Magang</h3>
                    <p class="text-gray-400 text-center max-w-md">
                        Klik nama peserta magang di sebelah kiri untuk melihat detail presensi dan statistik kehadiran
                        mereka.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>