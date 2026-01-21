@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    @php
        use Carbon\Carbon;
    @endphp

    {{-- Welcome Banner --}}
    <div class="w-full h-44 rounded-lg bg-blue-500 relative overflow-hidden mb-6">
        <img class="absolute inset-0 w-full h-full object-cover" src="{{ asset('assets/images/usernormal/bg-dash.svg') }}"
            alt="">
        <div class="relative h-full w-full px-6 flex flex-col justify-center">
            <p class="text-white text-xl md:text-3xl font-normal">Selamat datang di <span class="font-medium">SIMAGANG</span></p>
            <p class="text-white/80 text-sm mt-2">{{ $today->translatedFormat('l, j F Y') }}</p>
        </div>
    </div>

    {{-- Pengajuan Statistics Section --}}
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i class="ti ti-file-description text-blue-500"></i>
            Statistik Pengajuan
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
            {{-- Total --}}
            <div class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-2">
                    <span class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="ti ti-files text-gray-600 text-xl"></i>
                    </span>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $pengajuanStats['total'] }}</p>
                <p class="text-sm text-gray-500">Total Pengajuan</p>
            </div>



            {{-- Accept First --}}
            <div class="bg-white rounded-lg border border-blue-200 p-4 hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-2">
                    <span class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="ti ti-check text-blue-600 text-xl"></i>
                    </span>
                </div>
                <p class="text-3xl font-bold text-blue-600">{{ $pengajuanStats['accept_first'] }}</p>
                <p class="text-sm text-gray-500">Diterima Awal</p>
            </div>

            {{-- Accept Final --}}
            <div class="bg-white rounded-lg border border-green-200 p-4 hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-2">
                    <span class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="ti ti-circle-check text-green-600 text-xl"></i>
                    </span>
                </div>
                <p class="text-3xl font-bold text-green-600">{{ $pengajuanStats['accept_final'] }}</p>
                <p class="text-sm text-gray-500">Diterima Final</p>
            </div>

            {{-- Reject Final --}}
            <div class="bg-white rounded-lg border border-red-200 p-4 hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-2">
                    <span class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                        <i class="ti ti-circle-x text-red-600 text-xl"></i>
                    </span>
                </div>
                <p class="text-3xl font-bold text-red-600">{{ $pengajuanStats['reject_final'] }}</p>
                <p class="text-sm text-gray-500">Ditolak</p>
            </div>

            {{-- Expired --}}
            <div class="bg-white rounded-lg border border-gray-300 p-4 hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-2">
                    <span class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                        <i class="ti ti-clock-off text-gray-600 text-xl"></i>
                    </span>
                </div>
                <p class="text-3xl font-bold text-gray-600">{{ $pengajuanStats['expired'] }}</p>
                <p class="text-sm text-gray-500">Expired</p>
            </div>
        </div>
    </div>

    {{-- Today's Attendance Section --}}
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i class="ti ti-calendar-check text-green-500"></i>
            Presensi Hari Ini
            <span class="text-sm font-normal text-gray-400">({{ $today->translatedFormat('j F Y') }})</span>
        </h2>

        {{-- Attendance Stats Summary --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <div class="flex items-center gap-3">
                    <span class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="ti ti-users text-blue-600 text-2xl"></i>
                    </span>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $attendanceStats['total_active'] }}</p>
                        <p class="text-xs text-gray-500">Total Magang Aktif</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-green-200 p-4">
                <div class="flex items-center gap-3">
                    <span class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="ti ti-check text-green-600 text-2xl"></i>
                    </span>
                    <div>
                        <p class="text-2xl font-bold text-green-600">{{ $attendanceStats['hadir'] }}</p>
                        <p class="text-xs text-gray-500">Hadir</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-yellow-200 p-4">
                <div class="flex items-center gap-3">
                    <span class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                        <i class="ti ti-mail text-yellow-600 text-2xl"></i>
                    </span>
                    <div>
                        <p class="text-2xl font-bold text-yellow-600">{{ $attendanceStats['izin'] }}</p>
                        <p class="text-xs text-gray-500">Izin</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-orange-200 p-4">
                <div class="flex items-center gap-3">
                    <span class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center">
                        <i class="ti ti-first-aid-kit text-orange-600 text-2xl"></i>
                    </span>
                    <div>
                        <p class="text-2xl font-bold text-orange-600">{{ $attendanceStats['sakit'] }}</p>
                        <p class="text-xs text-gray-500">Sakit</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-red-200 p-4">
                <div class="flex items-center gap-3">
                    <span class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                        <i class="ti ti-clock-exclamation text-red-600 text-2xl"></i>
                    </span>
                    <div>
                        <p class="text-2xl font-bold text-red-600">{{ $attendanceStats['belum_absen'] }}</p>
                        <p class="text-xs text-gray-500">Belum Absen</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Attendance Table Per Intern --}}
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Nama Peserta</th>
                            <th class="px-4 py-3">Akademik</th>
                            <th class="px-4 py-3">Bidang</th>
                            <th class="px-4 py-3 text-center">Status Presensi</th>
                            <th class="px-4 py-3">Uraian Aktivitas</th>
                            <th class="px-4 py-3 text-center">Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($todayAttendance as $index => $data)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-medium">
                                            {{ strtoupper(substr($data['user']->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $data['user']->name }}</p>
                                            <p class="text-xs text-gray-400">{{ $data['user']->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-800">{{ $data['user']->institusi ?? '-' }}</span>
                                        <span class="text-xs">{{ $data['user']->prodi ?? '-' }} (Sem. {{ $data['user']->semester ?? '-' }})</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $data['pengajuan']->bidang_tujuan ?? '-' }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if(!$data['isInternshipDay'])
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-500 border border-gray-200">
                                            <i class="ti ti-minus"></i> Libur
                                        </span>
                                    @elseif($data['absensi'])
                                        @php
                                            $statusColors = [
                                                'hadir' => 'bg-green-100 text-green-700 border-green-300',
                                                'izin' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                                                'sakit' => 'bg-orange-100 text-orange-700 border-orange-300',
                                            ];
                                            $statusIcons = [
                                                'hadir' => 'ti-check',
                                                'izin' => 'ti-mail',
                                                'sakit' => 'ti-first-aid-kit',
                                            ];
                                            $statusLabels = [
                                                'hadir' => 'Hadir',
                                                'izin' => 'Izin',
                                                'sakit' => 'Sakit',
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs border {{ $statusColors[$data['absensi']->status] ?? 'bg-gray-100 text-gray-600' }}">
                                            <i class="ti {{ $statusIcons[$data['absensi']->status] ?? 'ti-circle' }}"></i>
                                            {{ $statusLabels[$data['absensi']->status] ?? ucfirst($data['absensi']->status) }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs bg-red-100 text-red-600 border border-red-300">
                                            <i class="ti ti-clock-exclamation"></i> Belum Absen
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($data['absensi'] && $data['absensi']->uraian_aktivitas)
                                        <p class="line-clamp-2 max-w-xs text-gray-600" title="{{ $data['absensi']->uraian_aktivitas }}">
                                            {{ $data['absensi']->uraian_aktivitas }}
                                        </p>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($data['absensi'] && $data['absensi']->verifikasi)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs bg-green-100 text-green-700 border border-green-300">
                                            <i class="ti ti-check"></i> Ya
                                        </span>
                                    @elseif($data['absensi'])
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs bg-amber-100 text-amber-700 border border-amber-300">
                                            <i class="ti ti-clock"></i> Pending
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b">
                                <td colspan="7" class="px-4 py-10 text-center text-gray-400">
                                    <i class="ti ti-users-off text-4xl"></i>
                                    <p class="mt-2">Tidak ada peserta magang aktif</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ url('/daftar-pengajuan') }}" class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md hover:border-blue-300 transition-all flex items-center gap-4">
            <span class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                <i class="ti ti-file-description text-blue-600 text-2xl"></i>
            </span>
            <div class="flex-1">
                <p class="font-semibold text-gray-800">Daftar Pengajuan</p>
                <p class="text-sm text-gray-500">Kelola pengajuan magang</p>
            </div>
            <i class="ti ti-chevron-right text-gray-400"></i>
        </a>

        <a href="{{ url('/monitor-absensi') }}" class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md hover:border-green-300 transition-all flex items-center gap-4">
            <span class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                <i class="ti ti-calendar-check text-green-600 text-2xl"></i>
            </span>
            <div class="flex-1">
                <p class="font-semibold text-gray-800">Monitor Presensi</p>
                <p class="text-sm text-gray-500">Lihat detail presensi</p>
            </div>
            <i class="ti ti-chevron-right text-gray-400"></i>
        </a>

    </div>
@endsection
